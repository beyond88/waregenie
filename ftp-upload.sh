#!/bin/bash

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
            # Unknown option
            ;;
    esac
    shift
done

# Check required parameters
if [[ -z "$SERVER" || -z "$REMOTE_DIR" ]]; then
    echo "Usage: $0 --server <server> --remote-dir <remote_dir> [--exclude <pattern>]"
    exit 1
fi

# Upload files via FTP
lftp -c "open -u $FTP_USERNAME,$FTP_PASSWORD $SERVER; set ftp:ssl-allow no; mirror --reverse --verbose --exclude-glob $EXCLUDE . $REMOTE_DIR"
