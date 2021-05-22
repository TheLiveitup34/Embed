# Embed
 Embed is a parser to translate text into PHP variables given in a array from a HTML document


**Clone and run for a quick way to see Embed in action.**
```
git clone https://github.com/RKStudioTM/Embed
cd Embed
```


Embed parser needs just this file:

- `embed.php` - Parses the file and displays the finalized output with given data


## To Use Embed

To clone and run this repository you'll need [Git](https://git-scm.com) and a [PHP](https://www.php.net/downloads) server installed on your computer. From your command line:

```bash
# Clone this repository
git clone https://github.com/RKStudioTM/ChatMC

# Call class in php 
require_once('embed.php');
$embed = new Embed();

# Load File from Directory / URL 
$embed->callFile(DIRECTORY_URL_HERE, DATA_ARRAY_HERE);
```

## Example Data array
```bash
# Data can be as such
$data = [
    "title" => "This is a title" 
];

# Called on output file as such
{{ title }}
```
Data can be called in multiple arrays using . as a way to define child arrays

## Example Sub array
```bash
# Data can be as such
$data = [
    "user" => [
        "first_name" => "John",
        "last_name" => "Doe",
        "age" => 24
    ] 
];

# Called on output file as such
{{ user.first_name }}
{{ user.last_name }}
{{ user.age }}
```


## License

[MIT License](LICENSE)

