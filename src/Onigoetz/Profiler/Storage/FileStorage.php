<?php namespace Onigoetz\Profiler\Storage;

class FileStorage implements StorageInterface {

    private $path;
    private $extension = '.serialized';

    public function __construct(array $options){
        if(!array_key_exists('path', $options)) {
            throw new Exception("Can't find a storage path for the profiler runs");
        }

        $this->path = $options['path'];
    }

    /**
     * Retrieve request specified by id argument, if second argument is specified, array of requests from id to last
     * will be returned
     */
    public function get($id = null, $last = null)
    {
        if ($id && !$last) {
            if (!is_readable($this->path . '/' . $id . $this->extension))
                return null;

            return new Request(
                unserialize(file_get_contents($this->path . '/' . $id . $this->extension), true)
            );
        }

        $files = glob($this->path . '/*' . $this->extension);

        $id = ($id) ? $id . $this->extension : first($files);
        $last = ($last) ? $last . $this->extension : end($files);

        $requests = array();
        $add = false;

        foreach ($files as $file) {
            if ($file == $id)
                $add = true;
            elseif ($file == $last)
                $add = false;

            if (!$add)
                continue;

            $requests[] = new Request(
                unserialize(file_get_contents($file), true)
            );
        }

        return $requests;
    }

    public function put($request) {
        file_put_contents(
            $this->path . '/' . $request->id . $this->extension,
            serialize($request)
        );
    }



}
