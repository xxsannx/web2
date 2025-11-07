#!/bin/bash

# Monitoring Setup Script untuk Bobobox Clone
# Run with: bash setup_monitoring.sh

set -e

echo "========================================="
echo "Pineus Tilu - Monitoring Setup"
echo "========================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
  echo -e "${RED}Please run as root (use sudo)${NC}"
  exit 1
fi

echo -e "${YELLOW}[1/8] Installing Node Exporter...${NC}"
cd /tmp

# Remove old files if exist
rm -rf node_exporter-1.7.0.linux-amd64*
rm -rf /usr/local/bin/node_exporter

# Download
wget -q https://github.com/prometheus/node_exporter/releases/download/v1.7.0/node_exporter-1.7.0.linux-amd64.tar.gz
tar xvf node_exporter-1.7.0.linux-amd64.tar.gz > /dev/null

# Move to /usr/local/bin
mv node_exporter-1.7.0.linux-amd64 /usr/local/bin/node_exporter

# Create user
id -u node_exporter &>/dev/null || useradd --no-create-home --shell /bin/false node_exporter
chown -R node_exporter:node_exporter /usr/local/bin/node_exporter

# Stop service if running
systemctl stop node_exporter 2>/dev/null || true

# Create service
cat > /etc/systemd/system/node_exporter.service <<'EOF'
[Unit]
Description=Node Exporter
Wants=network-online.target
After=network-online.target

[Service]
User=node_exporter
Group=node_exporter
Type=simple
ExecStart=/usr/local/bin/node_exporter/node_exporter

[Install]
WantedBy=multi-user.target
EOF

systemctl daemon-reload
systemctl start node_exporter
systemctl enable node_exporter
echo -e "${GREEN}✓ Node Exporter installed${NC}"

echo -e "${YELLOW}[2/8] Installing Prometheus...${NC}"
cd /tmp

# Remove old files if exist
rm -rf prometheus-2.48.0.linux-amd64*
rm -rf /usr/local/bin/prometheus

# Download
wget -q https://github.com/prometheus/prometheus/releases/download/v2.48.0/prometheus-2.48.0.linux-amd64.tar.gz
tar xvf prometheus-2.48.0.linux-amd64.tar.gz > /dev/null

# Move to /usr/local/bin
mv prometheus-2.48.0.linux-amd64 /usr/local/bin/prometheus

# Create user and directories
id -u prometheus &>/dev/null || useradd --no-create-home --shell /bin/false prometheus
mkdir -p /etc/prometheus
mkdir -p /var/lib/prometheus
chown -R prometheus:prometheus /usr/local/bin/prometheus
chown -R prometheus:prometheus /etc/prometheus
chown -R prometheus:prometheus /var/lib/prometheus

# Create config
cat > /etc/prometheus/prometheus.yml <<'EOF'
global:
  scrape_interval: 15s
  evaluation_interval: 15s

scrape_configs:
  - job_name: 'prometheus'
    static_configs:
      - targets: ['localhost:9090']

  - job_name: 'node_exporter'
    static_configs:
      - targets: ['localhost:9100']

  - job_name: 'bobobox_laravel'
    static_configs:
      - targets: ['localhost:8000']
    metrics_path: '/metrics'
    scrape_interval: 30s
EOF

# Stop service if running
systemctl stop prometheus 2>/dev/null || true

# Create service
cat > /etc/systemd/system/prometheus.service <<'EOF'
[Unit]
Description=Prometheus
Wants=network-online.target
After=network-online.target

[Service]
User=prometheus
Group=prometheus
Type=simple
ExecStart=/usr/local/bin/prometheus/prometheus \
  --config.file /etc/prometheus/prometheus.yml \
  --storage.tsdb.path /var/lib/prometheus/ \
  --web.console.templates=/usr/local/bin/prometheus/consoles \
  --web.console.libraries=/usr/local/bin/prometheus/console_libraries

[Install]
WantedBy=multi-user.target
EOF

systemctl daemon-reload
systemctl start prometheus
systemctl enable prometheus
echo -e "${GREEN}✓ Prometheus installed${NC}"

echo -e "${YELLOW}[3/8] Installing Grafana...${NC}"

# Check if Grafana is already installed
if systemctl is-active --quiet grafana-server; then
  echo -e "${YELLOW}⚠ Grafana already installed and running${NC}"
else
  # Install dependencies
  apt-get install -y apt-transport-https software-properties-common wget > /dev/null 2>&1
  
  # Add GPG key
  wget -q -O - https://packages.grafana.com/gpg.key | apt-key add - > /dev/null 2>&1
  
  # Add repository
  if ! grep -q "packages.grafana.com" /etc/apt/sources.list.d/grafana.list 2>/dev/null; then
    echo "deb https://packages.grafana.com/oss/deb stable main" | tee -a /etc/apt/sources.list.d/grafana.list > /dev/null
  fi
  
  # Update and install
  apt-get update > /dev/null 2>&1
  apt-get install -y grafana > /dev/null 2>&1
  
  systemctl start grafana-server
  systemctl enable grafana-server
fi
echo -e "${GREEN}✓ Grafana installed${NC}"

echo -e "${YELLOW}[4/8] Configuring MySQL (if running)...${NC}"
if systemctl is-active --quiet mysql; then
  echo -e "${GREEN}✓ MySQL is running${NC}"
else
  echo -e "${YELLOW}⚠ MySQL is not running. Starting MySQL...${NC}"
  systemctl start mysql 2>/dev/null || echo -e "${YELLOW}⚠ Could not start MySQL${NC}"
fi

echo -e "${YELLOW}[5/8] Checking Services Status...${NC}"
sleep 3

# Check services
services=("node_exporter" "prometheus" "grafana-server")
all_ok=true

for service in "${services[@]}"; do
  if systemctl is-active --quiet $service; then
    echo -e "${GREEN}✓ $service: Running${NC}"
  else
    echo -e "${RED}✗ $service: Failed${NC}"
    all_ok=false
  fi
done

echo ""
echo -e "${YELLOW}[6/8] Verifying Ports...${NC}"
sleep 2

# Check if ports are listening
check_port() {
  local port=$1
  local name=$2
  if ss -tuln | grep -q ":$port "; then
    echo -e "${GREEN}✓ Port $port ($name) is listening${NC}"
  else
    echo -e "${RED}✗ Port $port ($name) is not listening${NC}"
  fi
}

check_port 9090 "Prometheus"
check_port 9100 "Node Exporter"
check_port 3000 "Grafana"

echo ""
echo -e "${YELLOW}[7/8] Testing Endpoints...${NC}"
sleep 2

# Test Prometheus
if curl -s http://localhost:9090/-/healthy | grep -q "Prometheus"; then
  echo -e "${GREEN}✓ Prometheus API is responding${NC}"
else
  echo -e "${YELLOW}⚠ Prometheus API check failed${NC}"
fi

# Test Node Exporter
if curl -s http://localhost:9100/metrics | grep -q "node_"; then
  echo -e "${GREEN}✓ Node Exporter metrics available${NC}"
else
  echo -e "${YELLOW}⚠ Node Exporter metrics check failed${NC}"
fi

# Test Grafana
if curl -s http://localhost:3000/api/health | grep -q "ok"; then
  echo -e "${GREEN}✓ Grafana API is responding${NC}"
else
  echo -e "${YELLOW}⚠ Grafana API check failed${NC}"
fi

echo ""
echo -e "${YELLOW}[8/8] Creating helper scripts...${NC}"

# Create restart script
cat > /usr/local/bin/restart-monitoring.sh <<'EOF'
#!/bin/bash
echo "Restarting monitoring services..."
systemctl restart node_exporter
systemctl restart prometheus
systemctl restart grafana-server
echo "Done!"
systemctl status node_exporter --no-pager | head -n 3
systemctl status prometheus --no-pager | head -n 3
systemctl status grafana-server --no-pager | head -n 3
EOF

chmod +x /usr/local/bin/restart-monitoring.sh

# Create status check script
cat > /usr/local/bin/check-monitoring.sh <<'EOF'
#!/bin/bash
echo "Monitoring Services Status"
echo "=========================="
systemctl status node_exporter --no-pager | head -n 3
echo ""
systemctl status prometheus --no-pager | head -n 3
echo ""
systemctl status grafana-server --no-pager | head -n 3
echo ""
echo "Port Status"
echo "==========="
ss -tuln | grep -E ":(9090|9100|3000) "
EOF

chmod +x /usr/local/bin/check-monitoring.sh

echo -e "${GREEN}✓ Helper scripts created${NC}"

echo ""
echo -e "${GREEN}=========================================${NC}"
echo -e "${GREEN}Monitoring Stack Installation Complete!${NC}"
echo -e "${GREEN}=========================================${NC}"
echo ""
echo "Access URLs:"
echo -e "  ${YELLOW}Prometheus:${NC}     http://localhost:9090"
echo -e "  ${YELLOW}Grafana:${NC}        http://localhost:3000 (admin/admin)"
echo -e "  ${YELLOW}Node Exporter:${NC}  http://localhost:9100/metrics"
echo ""
echo "Useful Commands:"
echo -e "  ${YELLOW}Check status:${NC}   sudo check-monitoring.sh"
echo -e "  ${YELLOW}Restart all:${NC}    sudo restart-monitoring.sh"
echo -e "  ${YELLOW}View logs:${NC}      sudo journalctl -u prometheus -f"
echo ""
echo "Next Steps:"
echo "  1. Start Laravel: cd ~/web2 && php artisan serve"
echo "  2. Login to Grafana (admin/admin)"
echo "  3. Add Prometheus data source (http://localhost:9090)"
echo "  4. Import dashboard ID: 1860 for system metrics"
echo "  5. Create custom dashboard for Pineus Tilu metrics"
echo ""

if [ "$all_ok" = false ]; then
  echo -e "${YELLOW}⚠ Some services failed to start. Check logs with:${NC}"
  echo "  sudo journalctl -xe"
  exit 1
fi
