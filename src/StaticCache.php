<?php
/**
 * Static caching library. So simple, you should KISS it.
 *
 *
 * @author bbieber
 *
 */
class StaticCache
{
    /**
     * The web root where files will be stored
     *
     * @var string
     */
    protected $root_dir;

    /**
     * If existing files should be overwritten, typically not needed
     *
     * @var bool
     */
    protected $update_files = false;

    /**
     * Default options for the class
     *
     * @var array
     */
    protected $default_options = array(
        'update_files' => false
    );

    /**
     * Construct a new StaticCache lib
     *
     * @param array $options Associative array of options
     *
     * @see StaticCache::setOptions()
     */
    public function __construct($options = array())
    {
        if (!isset($options['root_dir'])) {
            // Use the server's document root by default
            $options['root_dir'] = $_SERVER['DOCUMENT_ROOT'];
        }
        $this->setOptions($options);
    }

    /**
     * Set configuration options for the cache library
     *
     * @param array $options Associative array of options
     */
    public function setOptions($options = array())
    {
        $options = $options + $this->default_options;

        $this->root_dir     = $options['root_dir'];
        $this->update_files = (bool)$options['update_files'];
    }

    /**
     * Attempt to get cached output
     *
     * @param string $request_uri Request URI, usually $_SERVER['REQUEST_URI']
     *
     * @return boolean|string
     */
    public function get($request_uri)
    {
        $file = $this->getLocalFilename($request_uri);

        if (!is_readable($file)) {
            return false;
        }

        if ($data = file_get_contents($file)) {
            return $data;
        }

        return false;
    }

    /**
     * Save the data to the key specified
     *
     * @param string $data        Rendered output
     * @param string $request_uri Request URI, usually $_SERVER['REQUEST_URI']
     *
     * @return boolean
     */
    public function save($data, $request_uri)
    {
        $file = $this->getLocalFilename($request_uri);
        $this->createDirs($file);
        return $this->saveCacheFile($file, $data);
    }

    /**
     * Convert the request_uri to a local filename
     *
     * @param string $request_uri The request URI
     *
     * @throws Exception
     *
     * @return string
     */
    protected function getLocalFilename($request_uri)
    {
        if (false !== strpos($request_uri, '..')) {
            throw new Exception('upper directory reference .. cannot be used');
        }

        if ($request_uri[0] !== '/') {
            // add leading slash
            $request_uri = DIRECTORY_SEPARATOR . $request_uri;
        }

        return $this->root_dir.$request_uri;
    }

    /**
     * Create parent directories for the file
     *
     * @param string $file Local filename
     *
     * @throws Exception
     *
     * @return boolean
     */
    protected function createDirs($file)
    {
        $dir = dirname($file);

        if (is_dir($dir)) {
            return true;
        }

        if (false === mkdir($dir, 0777, true)) {
            throw new Exception('Could not create directory structure for '.$file);
        }
        return true;
    }

    /**
     * Save contents to specified filename
     * 
     * This is a hardended version of file_put_contents
     *
     * @param string $file     Local filename to write
     * @param string $contents Contents of the file
     *
     * @throws Exception
     *
     * @return boolean
     */
    protected function saveCacheFile($file, $contents)
    {
        $len = strlen($contents);
    
        $cachefile_fp = @fopen($file, 'xb'); // x is the O_CREAT|O_EXCL mode
        if ($cachefile_fp !== false) {
            // create file
            if (fwrite($cachefile_fp, $contents, $len) < $len) {
                fclose($cachefile_fp);
                throw new Exception("Could not write $file.");
            }
        } elseif (false === $this->update_files) {
            throw new Exception('File already exists, set update_files=>true or empty the cache');
        } else { // update file
            $cachefile_lstat = lstat($file);
            $cachefile_fp = @fopen($file, 'wb');
            if (!$cachefile_fp) {
                throw new Exception("Could not open $file for writing. Likely a permissions error.");
            }
    
            $cachefile_fstat = fstat($cachefile_fp);
            if (
            $cachefile_lstat['mode'] == $cachefile_fstat['mode'] &&
            $cachefile_lstat['ino']  == $cachefile_fstat['ino'] &&
            $cachefile_lstat['dev']  == $cachefile_fstat['dev'] &&
            $cachefile_fstat['nlink'] === 1
            ) {
                if (fwrite($cachefile_fp, $contents, $len) < $len) {
                    fclose($cachefile_fp);
                    throw new Exception("Could not write $file.");
                }
            } else {
                fclose($cachefile_fp);
                $link = function_exists('readlink') ? readlink($file) : $file;
                throw new Exception('SECURITY ERROR: Will not write to ' . $file . ' as it is symlinked to ' . $link . ' - Possible symlink attack');
            }
        }
    
        fclose($cachefile_fp);
        return true;
    }
}