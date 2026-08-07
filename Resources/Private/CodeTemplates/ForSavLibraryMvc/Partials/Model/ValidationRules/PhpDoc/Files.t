<f:variable name="imagefile">'image/avif','image/gif','image/jpeg','image/tiff','image/bmp','image/x-pcx','image/x-tga','image/png','application/pdf','application/illustrator','image/svg+xml','image/webp'</f:variable>
<f:variable name="mediafile">'audia/3gpp','video/3gpp','audio/aac','application/postscript','audio/aiff','image/avif','image/bmp','audio/flac','image/gif','image/heic','image/x-icon','image/jpeg','audio/mp4','video/x-m4v','video/quicktime','mp3audio/mpeg','video/mp4','video/ogg','audio/opus','application/pdf','image/png','image/vnd.adobe.photoshop','image/svg+xml','audio/wav','video/webm','image/webp'</f:variable>
<f:variable name="textfile">'text/css','text/csv','text/html','application/javascript','application/json','text/markdown','text/x-rst','application/rtf','application/sql','text/x-template','text/plain','text/x-typoscript','application/xliff+xml','application/xml','text/yaml'</f:variable>

#[FileUpload(
    validation: [
        'fileSize' => ['minimum' => '0K', 'maximum' => '2M'],
		'maxFiles' => {f:if(condition:'{field.conf_files}', then:'{field.conf_files}', else:'1')},
        'mimeType' => [
            'allowedMimeTypes' => [<f:format.raw>{{field.conf_files_type}}</f:format.raw>],
            'ignoreFileExtensionCheck' => false,
            'notAllowedMessage' => 'LLL:EXT:sav_library_mvc/Resources/Private/Language/locallang_db.xlf:upload.failed',
            'invalidExtensionMessage' => 'LLL:EXT:sav_library_mvc/Resources/Private/Language/locallang_db.xlf:upload.invalidFileExtension',
        ],
    ],
    uploadFolder: '{field.conf_files_uploadFolder}',
)]
    