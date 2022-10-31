# CLI Image Handler

## Features

* **Save** images to your selected storages.
* **Delete** images from storages.
* **Retrieve** images from storages.

## Getting the app ready

To clone and run this application, you'll need [Git](https://git-scm.com), [PHP](https://www.php.net/) along with [composer](https://getcomposer.org/). From your command line:

```bash
# Clone this repository
$ git clone REPO

# Go into the repository
$ cd path/to/basekit

# Install dependencies
$ composer install
```
> **Note**
> This app assumes you are running it in a unix based OS.

> **Note**
> If after making `bin/basekit` an executable you keep receiving an error like `error: /usr/bin/env: ‘php\r’: No such file or directory` try installing package `dos2unix` and running `dos2unix bin/basekit` 


## Usage
```bash
# Go to project root directory
$ cd path/to/basekit

# Then to bin directory
$ cd bin/

# Run
$ ./basekit [command] [options]
```

## Available commands, required fields and options
- **Save** - Saves an image to a specified storage service
  - Required field: **image_path** (The image URL)
  - Option: **--storage**:FileSystem
    - Examples:
      - ./basekit save image_url_here (Will save to FileSystem since it's the default storage)
      - ./basekit save image_url_here --storage=S3 (Will save to S3 if integrated, if not it will return error message)

- **Delete** - Deletes an image from a specified storage - Returns error if image with the ID provided does not exist in the provided storage.
    - Required field: **image_id**
    - Option: **--fromStorage**:FileSystem
        - Examples:
            - ./basekit delete image_id (Will delete image with ID image_id from FileSystem since it's the default storage)
            - ./basekit delete image_id --storage=S3 (Will delete image with ID image_id_here from S3 if integrated, if not it will return error message)

- **Retrieve**  -Retrieves an image from a specified storage - Returns error if image with the ID provided does not exist in the provided storage.
    - Required field: **image_id**
    - Option: **--fromStorage**:FileSystem
        - Examples:
            - ./basekit retrieve image_id (Will retrieve image with ID image_id from FileSystem since it's the default storage)
            - ./basekit retrieve image_id --storage=S3 (Will retrieve image with ID image_id_here from S3 if integrated, if not it will return error message)

Can also view the required fields and available options for a command by typing `./basekit [command] --help`

## Adding a new Storage Service integration
- Create a new Storage class and implement `StorageInterface`
- Add a new case for the new Storage in `StorageEnum`
- Add a new check for the new Storage in `StorageFactory` `(e.g. if ($lowerCaseStorage === strtolower(StorageEnum::MY_NEW_STORAGE->value)) return MyNewStorage::make())`

