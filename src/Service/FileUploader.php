<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload($files)
    {
        $filenames = [];
        foreach ($files as $file) {
            $originFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename   = transliterator_transliterate(
                'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                $originFilename
            );
            $newFilename    = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            $filenames[]    = $newFilename;

            try {
                $file->move($this->getTargetDirectory(), $newFilename);
            } catch (FileException $e) {
            }
        }
        return $filenames;
    }

    public function removePhotos($photos)
    {
        $filesystem = new Filesystem();
        foreach ($photos as $photo) {
            $filesystem->remove($this->getTargetDirectory() . '/' . $photo);
        }
    }

    public function removePhotosFromUser($photosByUser)
    {
        $photos = [];
        foreach ($photosByUser as $photo) {
            $photos = array_merge(array_values($photos), array_values($photo['photos']));
        }
        $this->removePhotos($photos);
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
