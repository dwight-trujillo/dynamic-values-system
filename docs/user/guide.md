# Dynamic Values System - User Guide

## Installation

### Using Docker (Recommended)
 + "`" + ash
docker-compose up -d
 + "`" + 

### Manual Installation
 + "`" + ash
composer install
cp .env.example .env
php -S localhost:8080 -t public
 + "`" + 

## API Usage

### Get all values
 + "`" + ash
curl http://localhost:8080/api.php
 + "`" + 

### Get specific value
 + "`" + ash
curl http://localhost:8080/api.php?key=random
 + "`" + 

### Health check
 + "`" + ash
curl http://localhost:8080/health.php
 + "`" + 

## Configuration

Edit the .env file to configure Redis connections and rate limits.
