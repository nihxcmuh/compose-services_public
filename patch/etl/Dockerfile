# set base image (host OS)
FROM python:3.9

# set the working directory in the container
WORKDIR /etl

# copy the dependencies file to the working directory
COPY requirements.txt .

# install dependencies
RUN pip install -r requirements.txt

CMD sleep infinity
