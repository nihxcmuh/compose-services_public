Edit by edward70932@gmail.com  
Fork from [c00cjz00/compose-services_google](https://github.com/c00cjz00/compose-services_google)  
[NCHC Slide](https://docs.google.com/presentation/d/1oUV6kYTRqs_jEYuyzsyYqLYIDtNtl-Ze61hfGxtDSl0/edit#slide=id.g196fd36a755_0_261)

# Outline
- [Outline](#outline)
- [1. SYSTEM](#1-system)
- [2. QUICK INSTALL](#2-quick-install)
- [3. Fake data upload (這個是創假資料，不要在正式環境使用)](#3-fake-data-upload-這個是創假資料不要在正式環境使用)
  - [1. CREATE DATA](#1-create-data)
  - [2. UPLOAD DATA](#2-upload-data)
- [4. Update Server](#4-update-server)
- [5. Backup](#5-backup)
- [6. Restore](#6-restore)
- [Setting your own Data Dictionary](#setting-your-own-data-dictionary)
- [Setting up `program` and `project`](#setting-up-program-and-project)
- [ETL and Data Explorer Configurations](#etl-and-data-explorer-configurations)
- [Gen3 Portal Configurations Examples](#gen3-portal-configurations-examples)
- [Indexing auto trigger](#indexing-auto-trigger)
- [Gen3 Python SDK](#gen3-python-sdk)
- [Compose-Services document](#compose-services-document)
- [Key Documentation](#key-documentation)

# 1. SYSTEM 

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
Kill docker 
```
#stop all containers:
docker kill $(docker ps -q)

#remove all containers
docker rm $(docker ps -a -q)

#remove all docker images
docker rmi $(docker images -q)
```

# 2. QUICK INSTALL

a. Download gen3-compose and creds_setup 
```
HOSTNAME=google-gen4.biobank.org.tw
cd ~/
git clone https://github.com/c00cjz00/compose-services_google.git
cd ~/compose-services_google
./creds_setup.sh ${HOSTNAME}
```
b. Replace HOSTNAME
```
HOSTNAME=google-gen4.biobank.org.tw
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- patch/Secrets_biobank/fence-config.yaml
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- patch/Secrets_biobank/manifestservice_config.json
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- patch/www/curl.php
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- patch/www/graphQL*.php
~/compose-services_google/patch/replace google-gen3.biobank.org.tw ${HOSTNAME} -- patch/www/upload.php
```
c. Patch 
```
cd ~/compose-services_google
cp -rf patch/Secrets_biobank patch/Secrets
./patch.sh
```
d. Open the port 80 and 443, and then create ssl key for $HOSTNAME
```
sudo apt-get install letsencrypt -y
sudo letsencrypt certonly
```
e. Copy ssl key to gen3
```
sudo cp /etc/letsencrypt/live/${HOSTNAME}/fullchain.pem ~/compose-services_google/Secrets/TLS/service.crt
sudo cp /etc/letsencrypt/live/${HOSTNAME}/privkey.pem ~/compose-services_google/Secrets/TLS/service.key
```
f. Edit Secrets/fence-config.yaml for google Oauth 2.0 key 

OPEN URL https://console.developers.google.com/apis/credentials
```
client_id: 'xxxxx'
client_secret: 'xxxx'
```
g. Edit Secrets/fence-config.yaml for aws s3 access_key and bucket
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
h. Edit manifestservice_config.json for aws s3 access_key and bucket
```
{
        "manifest_bucket_name": "tcgademo",
        "hostname": "google-gen4.biobank.org.tw",
        "aws_access_key_id": "",
        "aws_secret_access_key": "",
        "prefix": "google-gen4.biobank.org.tw",
        "endpoint_url" : "https://s3-cloud.nchc.org.tw"
}
```
i. Edit Secrets/user.yaml
```
change summerhill001@gmail.com to your Email
```
j. Building Gen3 
```
docker-compose down
docker-compose up -d
```
# 3. Fake data upload (這個是創假資料，不要在正式環境使用)

## 1. CREATE DATA
<details>

TCGA link: https://github.com/c00cjz00/compose-services_tcga_slideimage

Create and download testData
```
export TEST_DATA_PATH="$(pwd)/testData"
mkdir -p "$TEST_DATA_PATH"
docker run -it -v "${TEST_DATA_PATH}:/mnt/data" --rm --name=dsim --entrypoint=data-simulator quay.io/cdis/data-simulator:master simulate --url https://s3.amazonaws.com/dictionary-artifacts/datadictionary/develop/schema.json --path /mnt/data --program jnkns --project jenkins --max_samples 10
```
</details>

## 2. UPLOAD DATA
<details>

a. Create Program
```
Goto https://google-gen4.biobank.org.tw/_root
Click “Use Form Submission”
At drop-down box, enter “program”
At dbgap_accession_number, enter “jk123”
At name, enter “jnkns”
Click “Generate submission JSON from form”
Click “Submit”
```

b. Create “jenkins” project under “jnkns” program
```
Goto https://google-gen4.biobank.org.tw/jnkns
🙋‍♂️ we will be uploading in order described in Secrets/testData/DataImportOrder.txt
click “Upload file”
select “project.json”
click “Submit”
```

c. Uploading metadata under “jenkins” project, under “jnkns” program
```
💡 here we are fulfilling data dictionary (DD model graph) requirement for your center data submission program
goto the project https://google-gen4.biobank.org.tw/jnkns-jenkins
click “Upload file”
select “experiment.json”
click “Submit”
```

d. do the same process as above
```
experiment.json
case.json
sample.json
slide.json
slide_count.json
slide_image.json
core_metadata_collection.json
```
</details>

# 4. Update Server

a. Edit nginx.conf, and remove "#"
```
location /guppy/ {
        proxy_pass http://guppy-service/;
}
```
b.  Running setup guppy 
```
bash ./guppy_setup.sh
```
c. Restart
```
docker-compose down
docker-compose up -d
```
d.  Running etl
```
docker cp ~/gen3/credentials_nihxcmuh.json etlservice:/etc/credentials.json 
docker exec  etlservice /etl/metadata --gen3_credentials_file /etc/credentials.json ls  |jq
```

# 5. Backup 

```
bash dump.sh
curl -sSL https://raw.githubusercontent.com/BretFisher/docker-vackup/main/vackup > vackup
sudo mv vackup /usr/local/bin/vackup
sudo chmod +x /usr/local/bin/vackup
#docker inspect postgres |grep "volume"
vackup export compose-services_google_psqldata psqldata.tar.gz
vackup export compose-services_google_esdata esdata.tar.gz
```

# 6. Restore

```
docker volume create compose-services_google_psqldata
docker volume create compose-services_google_esdata
vackup import psqldata.tar.gz compose-services_google_psqldata
vackup import esdata.tar.gz compose-services_google_esdata
```
# Setting your own Data Dictionary
examples:
* [MIRDC](https://github.com/uc-cdis/midrc_dictionary)  
* [GDC](https://github.com/uc-cdis/gdcdatamodel)
* [JCOIN](https://github.com/uc-cdis/JCOIN_datadictionary)

Where to put your own data dictionary? [here](datadictionary/gdcdictionary/schemas/)

Tools:
* [dictionaryutils](https://github.com/uc-cdis/dictionaryutils): You can use this tool to dump a dictionary into a single JSON file, and put it into S3.


# Setting up `program` and `project`
For example, program: `CMUH` project: `TSR`

a. Setup resource [code](patch/Secrets_biobank/user.yaml#L38-L54)  
```yaml
authz:
  # other setting...
  resources:
  - name: programs
    subresources:
    - name: CMUH
      subresources:
        - name: projects
          subresources:
            - name: TSR
  # other setting...
``` 
b. Setup policies [code](patch/Secrets_biobank/user.yaml#L56-L125) 
```yaml
authz:
  # other setting...
  policies:
  - id: CMUH
    role_ids:
    - reader
    - creator
    - updater
    - deleter
    - storage_reader
    - storage_writer
    resource_paths:
    - /programs/CMUH
    - /programs/CMUH/projects/TSR
  # other setting...
```
c. Give user policies [code](patch/Secrets_biobank/user.yaml#L208-L213)
```yaml
users:
  username:
    # other setting...
    policies:
      - CMUH
``` 
# ETL and Data Explorer Configurations
https://gen3.org/resources/operator/#8-etl-and-data-explorer-configurations

manifest examples: https://github.com/uc-cdis/cdis-manifest

[Code explanation](docs/data_explorer_conf.md) [:construction: Under editing] 

# Gen3 Portal Configurations Examples
https://gen3.org/resources/operator/#9-gen3-portal-configurations-examples

Official Documents: https://github.com/uc-cdis/data-portal/blob/master/docs/portal_config.md

# Indexing auto trigger

Resource https://github.com/ohsu-comp-bio/compose-services/tree/onprem/onprem

a. Add config below into `docker-compose.yml`
```yaml
services:
  s3indexer-service:
    image: "onprem/s3indexer"
    container_name: s3indexer-service
    volumes:
      - ./Secrets/s3indexer-state:/var/s3indexer/state # store re-try info
      - ./Secrets/fence-config.yaml:/var/s3indexer/fence-config.yaml # pass bucket info to s3clientindexer
      - ./Secrets/indexd_creds.json:/var/s3indexer/indexd_creds.json # read new files from indexd db
    networks:
      - devnet
    depends_on:
      - indexd-service
```

b. upload data  
Submitting Data Files and Linking Metadata in a Gen3 Data Commons. (https://gen3.org/resources/user/submit-data/)  
Enabling New Gen3 Object Management API (https://github.com/uc-cdis/cdis-data-client#enabling-new-gen3-object-management-api)

# Gen3 Python SDK
https://github.com/uc-cdis/gen3sdk-python

# Compose-Services document

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
