.. include:: ../../Includes.txt

.. _filesAndImages:

================
Files and Images
================


======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus MVC
======================================================= =========== ============ ==== ====
:ref:`filesAndImages.addIcon`                           Boolean     0            Yes  Yes
:ref:`filesAndImages.addLinkInEditMode`                 Boolean     0            Yes  No
:ref:`filesAndImages.addToUploadFolder`                 String      None         Yes  No
:ref:`filesAndImages.addToUploadFolderFromField`        Field name  None         Yes  No
:ref:`filesAndImages.alt`                               String      None         Yes  Yes
:ref:`filesAndImages.default`                           String      None         Yes  Yes
:ref:`filesAndImages.fieldAlt`                          Field name  None         Yes  Yes
:ref:`filesAndImages.fieldMessage`                      Field name  None         Yes  Yes
:ref:`filesAndImages.height`                            Integer     None         Yes  Yes
:ref:`filesAndImages.iframe`                            Boolean     0            Yes  No
:ref:`filesAndImages.message`                           String      None         Yes  Yes
:ref:`filesAndImages.onlyFileName`                      String      None         Yes  No
:ref:`filesAndImages.renderAsLink`                      Boolean     0            Yes  No
:ref:`filesAndImages.size`                              Integer     None         Yes  No
:ref:`filesAndImages.tsProperties`                      String      None         Yes  No
:ref:`filesAndImages.uploadFolder`                      String      None         Yes  Yes
:ref:`filesAndImages.width`                             Integer     None         Yes  Yes
======================================================= =========== ============ ==== ====


.. _filesAndImages.addIcon:

addIcon
=======

.. container:: table-row

    Property 
        addIcon    

    Data type
        Boolean

    Description
        Adds an icon in front of the hyperlink associated with the file.

    Default
        0


.. _filesAndImages.addLinkInEditMode:

addLinkInEditMode
=================

.. container:: table-row

    Property 
        addLinkInEditMode

    Data type
        Boolean
        
    Description
        A hyperlink to the file will be added in the edit mode.

    Default
        0


.. _filesAndImages.addToUploadFolder:

addToUploadFolder
=================

.. container:: table-row

    Property 
        addToUploadFolder

    Data type
        String

    Description
        Adds a subpath to the UploadFolder path.




.. _filesAndImages.addToUploadFolderFromField:

addToUploadFolderFromField
==========================

.. container:: table-row

    Property 
        addToUploadFolderFromField

    Data type
        Field name

    Description
        Adds the content of the field whose name is given by ``field_name`` to
        the uploadFolder attribute. This information is separated with an
        underscore.

        Example: if the ``field_name`` is ``my_field`` and its contents is ``123``,
        then

        ::

            AddToUploadFolderFromField = my_field;

        will add ``_123`` to the uploadFolder name.




.. _filesAndImages.alt:

alt
===

.. container:: table-row

    Property 
        alt

    Data type
        String

    Description
        Provides the HTML alt attribute for an image.



.. _filesAndImages.default:

default
=======

.. container:: table-row

    Property 
        default

    Data type
        String
    
    Description
        Defines the default image if the content of the field is null
        otherwise the default image is ``unknown.gif`` taken in the directory
        ``sav_library_Plus/Resources/Public/Images``.



.. _filesAndImages.fieldAlt:

fieldAlt
========

.. container:: table-row

    Property 
        fieldAlt

    Data type
        Field name

    Description
        Sets the ``alt`` attribute with the content of the field whose name is
        given by field_name.



.. _filesAndImages.fieldMessage:

fieldMessage
============

.. container:: table-row

    Property
        fieldMessage     

    Data type
        Field name

    Description
        Sets the attribute ``message`` with the content of the field whose name
        is given by field_name.


.. _filesAndImages.height:

height
======

.. container:: table-row

    Property 
        height

    Data type
        Integer
                
    Description
        Sets the height of an image or of the iframe.





.. _filesAndImages.iframe:

iframe
======

.. container:: table-row

    Property 
        iframe

    Data type
        Boolean

    Description
        Opens the image in an iframe.
        
    Default
        0


.. _filesAndImages.message:

message
=======

.. container:: table-row

    Property 
        message

    Data type
        String

    Description
        If the file is not an image, a hyperlink is created with the string.



.. _filesAndImages.onlyFileName:

onlyFileName
============

.. container:: table-row

    Property 
        onlyFileName

    Data type
        String
        
    Description
        Displays only the file name.


.. _filesAndImages.renderAsLink:

renderAsLink
============

.. container:: table-row

    Property 
        renderAsLink

    Data type
        Boolean
        
    Description
        If set, the image is rendered as a link.
        
        

.. _filesAndImages.size:

size
====

.. container:: table-row

    Property 
        size

    Data type
        Integer
        
    Description
        Sets the size attribute. It overwrites the same attribute in the TCA.




.. _filesAndImages.tsProperties:

tsProperties
============

.. container:: table-row

    Property 
        tsProperties

    Data type
        String

    Description
        It makes it possible to use the graphic possibilities of TYPO3. If
        set, an IMAGE cObject is generated with the given TypoScript properties.

        .. important::
        
            Do not forget that the configuration field is ended by a semi-column,
            therefore if you need a semi-column in your TypoScript, write it ``\\;``.



.. _filesAndImages.uploadFolder:

uploadFolder
============

.. container:: table-row

    Property 
        uploadFolder

    Data type
        String

    Description
        Sets the folder path where the file is stored. It overwrites the same
        attribute in the TCA.


.. _filesAndImages.width:

width
=====

.. container:: table-row

    Property 
        width

    Data type
        Integer
        
    Description
        Sets the width of an image or of the iframe.