FROM mysql:8.0-debian

VOLUME /var/lib/mysql

# Set the working directory to /app
WORKDIR /application

# Copy the current directory contents into the container at /app
ADD . /application

# Expose port 3306 to allow connections to the database
EXPOSE 3306

# Start the MySQL server when the container is run
CMD ["mysqld"]
