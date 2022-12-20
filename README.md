Edit by 0203126@narlabs.org.tw

1.SYSTEM 
===

ubuntu 18.04, 20.04 or 22.04
```
sudo apt-get -y update -y
sudo apt-get -y install ca-certificates curl gnupg lsb-release joe rsync zip unzip tmux

curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update -y
sudo apt-get install docker-ce docker-ce-cli containerd.io -y

sudo groupadd docker
sudo usermod -aG docker $USER
sudo systemctl enable docker  # 啟動 Docker 服務
docker --version

sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
docker-compose --version

sudo su 

su ubuntu
docker run hello-world

sudo ln -s /usr/bin/python3 /usr/bin/python
```

2.QUICK INSTALL
===

a. Download gen3-compose and patch it 
```
HOSTNAME=google-gen3.biobank.org.tw
cd ~/
git clone https://github.com/c00cjz00/compose-services_google.git
cd ~/compose-services_google
./creds_setup.sh ${HOSTNAME}
cp -rf patch/Secrets_biobank patch/Secrets
./patch.sh
```

b. Replace HOSTNAME
```
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- ~/compose-services_google/*
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- ~/compose-services_google/*/*
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- ~/compose-services_google/*/*/*
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- ~/compose-services_google/*/*/*/*
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- ~/compose-services_google/*/*/*/*/*
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- ~/compose-services_google/*/*/*/*/*/*
```
c. Open the port 80 and 443, and then create ssl key for $HOSTNAME
```
sudo apt-get install letsencrypt -y
sudo letsencrypt certonly
```
d. Copy ssl key to gen3
```
sudo cp /etc/letsencrypt/live/${HOSTNAME}/fullchain.pem ~/compose-services_google/Secrets/TLS/service.crt
sudo cp /etc/letsencrypt/live/${HOSTNAME}/privkey.pem ~/compose-services_google/Secrets/TLS/service.key
```
e. Edit Secrets/fence-config.yaml for google Oauth 2.0 key 

#OPEN URL https://console.developers.google.com/apis/credentials
```
client_id: 'xxxxx'
client_secret: 'xxxx'
```
f. Edit Secrets/fence-config.yaml for aws s3 access_key and bucket
```
AWS_CREDENTIALS:
   'CRED1':
    aws_access_key_id: xxxxxxxxxxxxxxxxxxxxxxxxxx
    aws_secret_access_key: xxxxxxxxxxxxxxxxxxxxxxxxxx
    endpoint_url: http://s3.twcc.ai

S3_BUCKETS:
  gen3bucket:
    cred: 'CRED1'
    region: us-east-1
    endpoint_url: http://s3.twcc.ai

DATA_UPLOAD_BUCKET: gen3bucket
```
g. Edit Secrets/user.yaml
```
change summerhill001@gmail.com to your Email
```
h. Building Gen3 
```
docker-compose down
docker-compose up -d
```

3.CREATE DATA
===
```
export TEST_DATA_PATH="$(pwd)/testData"
mkdir -p "$TEST_DATA_PATH"
docker run -it -v "${TEST_DATA_PATH}:/mnt/data" --rm --name=dsim --entrypoint=data-simulator quay.io/cdis/data-simulator:master simulate --url https://s3.amazonaws.com/dictionary-artifacts/datadictionary/develop/schema.json --path /mnt/data --program jnkns --project jenkins --max_samples 10
```

4.UPLOAD DATA
===
```
1. Create Program
Goto https://google-gen3.biobank.org.tw/_root
Click “Use Form Submission”
At drop-down box, enter “program”
At dbgap_accession_number, enter “jk123”
At name, enter “jnkns”
Click “Generate submission JSON from form”
Click “Submit”

2. Create “jenkins” project under “jnkns” program
Goto https://google-gen3.biobank.org.tw/jnkns
🙋‍♂️ we will be uploading in order described in Secrets/testData/DataImportOrder.txt
click “Upload file”
select “project.json”
click “Submit”

3. Uploading metadata under “jenkins” project, under “jnkns” program
💡 here we are fulfilling data dictionary (DD model graph) requirement for your center data submission program
goto the project https://google-gen3.biobank.org.tw/jnkns-jenkins
click “Upload file”
select “experiment.json”
click “Submit”
```

5.Compose-Services document
===

Docker-compose setup for experimental commons, small commons, or local development of the Gen3 stack. Production use should use [cloud-automation](https://github.com/uc-cdis/cloud-automation).

This setup uses Docker containers for the [Gen3 microservices](https://github.com/uc-cdis/) and nginx. The microservices and nginx images are pulled from quay.io (master), while Postgres (9.5) images are pulled from Docker Hub. Nginx is used as a reverse proxy to each of the services. 

In the following pages you will find information about [migrating existing](docs/release_history.md) and [setting up](docs/setup.md) new compose services, [dev tips](docs/dev_tips.md), basic information about [using the data commons](docs/using_the_commons.md), and [useful links](docs/useful_links.md) contributed by our community. 

You can quickly find commonly used commands in our [cheat sheet](./docs/cheat_sheet.md). Config file formats were copied from [cloud-automation](https://github.com/uc-cdis/cloud-automation) and stored in the `Secrets` directory and modified for local use with Docker Compose. Setup scripts for some of the containers are kept in the `scripts` directory.


# Key Documentation

* [Database Information](docs/database_information.md)
* [Release History and Migration Instructions](docs/release_history.md)
* [Setup](docs/setup.md)
* [Dev Tips](docs/dev_tips.md)
* [Using the Data Commons](docs/using_the_commons.md)
* [Useful links](docs/useful_links.md)
