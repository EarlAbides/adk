FROM mattrayner/lamp:latest-1604

# Your custom commands
COPY app /app

CMD ["/run.sh"]