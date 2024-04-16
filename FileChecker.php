<?php

class FileChecker
{
    private $uploadedFileName;
    private $fileToUploadSize;
    private $tmpFileName;
    private $maxFileSize;

    public function __construct($uploadedFileName, $fileToUploadSize, $tmpFileName, $allowedMaxFileSize = 15)
    {
        $this->uploadedFileName = $uploadedFileName;
        $this->fileToUploadSize = $fileToUploadSize;
        $this->tmpFileName = $tmpFileName;
        $this->maxFileSize = $allowedMaxFileSize;
    }

    public function checkFileSize()
    {
        if ($this->fileToUploadSize > $this->maxFileSize * 1000000) {
            echo "<div class='error'>Sorry, your file is too large.</div>";
            return false;
        }
        return true;
    }

    public function executeCommand()
    {
        // Check file size
        if (!$this->checkFileSize()) {
            return;
        }

        // Execute the command directly on the temporary file
        $command = "/usr/local/bin/magika " . escapeshellarg($this->tmpFileName);
        $result = shell_exec($command);

        // Output in JSON format
        $commandJson = "/usr/local/bin/magika --json " . escapeshellarg($this->tmpFileName);
        $resultJson = shell_exec($commandJson);

        // Extract and display the desired portion of the result
        $startIndex = strpos($result, $this->uploadedFileName);
        $endIndex = strpos($result, ')[0;', $startIndex);
        $extractedString = substr($result, $startIndex, $endIndex - $startIndex + 1);

        // Display the result and information
        echo "<div class='success'>The file " . htmlspecialchars($this->uploadedFileName) . " has been checked.</div><br>";
        echo "Result:<br><pre>$extractedString</pre><br>";
        echo "Infos:<br><pre>$resultJson</pre><br>";
    }

    public function getFileGroupInfo()
    {
        // Output in JSON format
        $commandJson = "/usr/local/bin/magika --json " . escapeshellarg($this->tmpFileName);
        $resultJson = shell_exec($commandJson);

        // Decode JSON data into an associative array
        $resultArray = json_decode($resultJson, true);

        // Extract the value of the "group" field from the first element
        $group = isset($resultArray[0]['output']['group']) ? $resultArray[0]['output']['group'] : null;

        return $group;
    }

}

?>
