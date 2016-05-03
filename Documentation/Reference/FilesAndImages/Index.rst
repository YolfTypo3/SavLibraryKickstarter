.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Files and images
----------------


======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus MVC
======================================================= =========== ============ ==== ====
:ref:`FilesAndImages.addIcon`                           Boolean     0            Yes  Yes
:ref:`FilesAndImages.addLinkInEditMode`                 Boolean     0            Yes  No
:ref:`FilesAndImages.addToUploadFolder`                 String      None         Yes  No
:ref:`FilesAndImages.addToUploadFolderFromField`        Field name  None         Yes  No
:ref:`FilesAndImages.alt`                               String      None         Yes  Yes
:ref:`FilesAndImages.default`                           String      None         Yes  Yes
:ref:`FilesAndImages.fieldAlt`                          Field name  None         Yes  Yes
:ref:`FilesAndImages.fieldMessage`                      Field name  None         Yes  Yes
:ref:`FilesAndImages.height`                            Integer     None         Yes  Yes
:ref:`FilesAndImages.iframe`                            Boolean     0            Yes  No
:ref:`FilesAndImages.message`                           String      None         Yes  Yes
:ref:`FilesAndImages.onlyFileName`                      String      None         Yes  No
:ref:`FilesAndImages.size`                              Integer     None         Yes  No
:ref:`FilesAndImages.tsProperties`                      String      None         Yes  No
:ref:`FilesAndImages.uploadFolder`                      String      None         Yes  No
:ref:`FilesAndImages.width`                             Integer     None         Yes  Yes
======================================================= =========== ============ ==== ====


.. _FilesAndImages.addIcon:

addIcon
^^^^^^^

.. container:: table-row

    Property 
        addIcon    

    Data type
        Boolean

    Description
        Adds an icon in front of the hyperlink associated with the file.

    Default
        0


.. _FilesAndImages.addLinkInEditMode:

addLinkInEditMode
^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property 
        addLinkInEditMode

    Data type
        Boolean
        
    Description
        A hyperlink to the file will be added in the edit mode.

    Default
        0


.. _FilesAndImages.addToUploadFolder:

addToUploadFolder
^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property 
        addToUploadFolder

    Data type
        String

    Description
        Adds a subpath to the UploadFolder path.




.. _FilesAndImages.addToUploadFolderFromField:

addToUploadFolderFromField
^^^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property 
        addToUploadFolderFromField

    Data type
        Field name

    Description
        Adds the content of the field whose name is given by "field\_name" to
        the uploadFolder attribute. This information is separated with an
        underscore.

        Example: if the field\_name is "my\_field" and its contents is "123",
        then

        ::

            AddToUploadFolderFromField = my_field;

        will add "\_123" to the uploadFolder name.




.. _FilesAndImages.alt:

alt
^^^

.. container:: table-row

    Property 
        alt

    Data type
        String

    Description
        Provides the HTML alt attribute for an image.



.. _FilesAndImages.default:

default
^^^^^^^

.. container:: table-row

    Property 
        default

    Data type
        String
    
    Description
        Defines the default image if the content of the field is null
        otherwise the default image is “unknown.gif” taken in the directory
        sav\_library\_Plus/Resources/Private/Images.



.. _FilesAndImages.fieldAlt:

fieldAlt
^^^^^^^^

.. container:: table-row

    Property 
        fieldAlt

    Data type
        Field name

    Description
        Sets the "alt" attribute with the content of the field whose name is
        given by field\_name.



.. _FilesAndImages.fieldMessage:

fieldMessage
^^^^^^^^^^^^

.. container:: table-row

    Property
        fieldMessage     

    Data type
        Field name

    Description
        Sets the attribute "message" with the content of the field whose name
        is given by field\_name.


.. _FilesAndImages.height:

height
^^^^^^

.. container:: table-row

    Property 
        height

    Data type
        Integer
                
    Description
        Sets the height of an image or of the iframe.





.. _FilesAndImages.iframe:

iframe
^^^^^^

.. container:: table-row

    Property 
        iframe

    Data type
        Boolean

    Description
        Opens the image in an iframe.
        
    Default
        0


.. _FilesAndImages.message:

message
^^^^^^^

.. container:: table-row

    Property 
        message

    Data type
        String

    Description
        If the file is not an image, a hyperlink is created with the string.



.. _FilesAndImages.onlyFileName:

onlyFileName
^^^^^^^^^^^^

.. container:: table-row

    Property 
        onlyFileName

    Data type
        String
        
    Description
        Displays only the file name.



.. _FilesAndImages.size:

size
^^^^

.. container:: table-row

    Property 
        size

    Data type
        Integer
        
    Description
        Sets the size attribute. It overwrites the same attribute in the TCA.




.. _FilesAndImages.tsProperties:

tsProperties
^^^^^^^^^^^^

.. container:: table-row

    Property 
        tsProperties

    Data type
        String

    Description
        It makes it possible to use the graphic possibilities of TYPO3. If
        set, an IMAGE cObject is generated with the given TS properties.

        .. important::
        
            Do not forget that the configuration field is ended by a semi-column,
            therefore if you need a semi-column in your TS write it “\;”



.. _FilesAndImages.uploadFolder:

uploadFolder
^^^^^^^^^^^^

.. container:: table-row

    Property 
        uploadFolder

    Data type
        String

    Description
        Sets the folder path where the file is stored. It overwrites the same
        attribute in the TCA.


.. _FilesAndImages.width:

width
^^^^^

.. container:: table-row

    Property 
        width

    Data type
        Integer
        
    Description
        Sets the width of an image or of the iframe.

