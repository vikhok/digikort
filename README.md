# digikort


## Install docker locally

To install Docker on Windows and macOS, follow the instructions below:

Windows

System Requirements: Ensure your system meets the following requirements:

Windows 10 (64-bit: Pro, Enterprise, or Education) or Windows Server 2016.
Enable virtualization in BIOS (check your PC's documentation on how to enable it).
Download Docker Desktop for Windows: Visit the Docker Desktop download page and download the installer for Windows: https://www.docker.com/products/docker-desktop

Install Docker Desktop:

Run the installer (.exe) you downloaded in step 2.
Follow the installation wizard's prompts, accepting the default settings.
After the installation is complete, Docker Desktop should start automatically.
Verify Docker installation: To check if Docker is running, open a Command Prompt or PowerShell and type:

css
Copy code
docker --version
You should see the installed Docker version.

macOS

System Requirements: Ensure your system meets the following requirements:

macOS 10.14 (Mojave) or newer.
At least 4 GB of RAM.
Download Docker Desktop for Mac: Visit the Docker Desktop download page and download the installer for macOS: https://www.docker.com/products/docker-desktop

Install Docker Desktop:

Open the downloaded .dmg file and drag the Docker icon to the Applications folder.
Open the Docker app from the Applications folder.
You may be prompted to provide your macOS password to proceed with the installation.
Verify Docker installation: To check if Docker is running, open Terminal and type:

css
Copy code
docker --version
You should see the installed Docker version.

After installing Docker on either Windows or macOS, you'll be able to use the docker command in the terminal (Command Prompt or PowerShell on Windows, Terminal on macOS) to manage Docker containers and images.

## Build docker image
```
# build image
docker build -t xampp-image .

# start image
docker run -d -p 80:80 -p 443:443 -p 3306:3306 --name xampp-container xampp-image

# connect to the container
docker exec -it xampp-container /bin/bash

```
## Push to GitHub Packages:
```
   docker login ghcr.io --username yourusername
   docker build -t ghcr.io/egdeconsulting/digikort:0.1.0 .
   docker push ghcr.io/egdeconsulting/digikort:0.1.0
```
