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
git clone https://github.com/RKStudioTM/Embed

# Call class in php 
require_once('embed.php');
# Loads file from Directory
$embed = new Embed(DIRECTORY_URL_HERE);

# Calls to parse and translate data to output
$embed->callFile(DATA_ARRAY_HERE);
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

## License

[MIT License](LICENSE)

