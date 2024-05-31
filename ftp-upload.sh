#!/bin/bash

# Function to create the .ftp directory (if it doesn't exist)
create_ftp_dir() {
  if [ ! -d ~/.ftp ]; then
    mkdir ~/.ftp
  fi
}

# Parse arguments
while [[ $# -gt 0 ]]; do
  case "$1" in
    --server)
      SERVER="$2"
      shift
      ;;
    --remote-dir)
      REMOTE_DIR="$2"
      shift
      ;;
    --exclude)
      EXCLUDE="$2"
      shift
      ;;
    *)
      echo "Error: Unknown option '$1'"
      exit 1
      ;;
  esac
  shift
done

# Check required parameters
if [[ -z "$SERVER" || -z "$REMOTE_DIR" ]]; then
  echo "Usage: $0 --server <server> --remote-dir <remote_dir> [--exclude <pattern>]"
  exit 1
fi

# Create the .ftp directory (optional)
create_ftp_dir

# Upload files via FTP
lftp -c "open -u $FTP_USERNAME,$FTP_PASSWORD $SERVER; set ftp:passive-mode yes; mirror --reverse --verbose --exclude-glob $EXCLUDE . $REMOTE_DIR"
