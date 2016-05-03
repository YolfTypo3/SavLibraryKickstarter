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



Checkboxes: several checkboxes
------------------------------

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`Checkboxes.checkboxSelectedImage`                 String                   Yes  Yes
:ref:`Checkboxes.checkboxNotSelectedImage`              String                   Yes  Yes
:ref:`Checkboxes.cols`                                  Integer     1            Yes  Yes
:ref:`Checkboxes.displayAsImage`                        Boolean     1            Yes  Yes
:ref:`Checkboxes.doNotDisplayIfNotChecked`              Boolean     0            Yes  Yes
:ref:`Checkboxes.nbItems`                               Integer     1            Yes  Yes
======================================================= =========== ============ ==== ====


.. _Checkboxes.checkboxSelectedImage:

checkboxSelectedImage
^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

  Property
    checkboxSelectedImage 

  Data type
    String    

  Description
    The string is used as a file name which is searched in the default
    icon directory and, if not found, in the extension icon directory. It
    replaces the default image for a selected checkbox.


.. _Checkboxes.checkboxNotSelectedImage:

checkboxNotSelectedImage
^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

  Property
    checkboxNotSelectedImage
    
  Data type
    String

  Description
    The string is used as a file name which is searched in the default
    icon directory and, if not found, in the extension icon directory. It
    replaces the default image for an unselected checkbox.


.. _Checkboxes.cols:

cols
^^^^

.. container:: table-row

  Property
    cols

  Data type
    Integer
    
  Description
    Number of columns to display.

  Default
    1


.. _Checkboxes.displayAsImage:

displayAsImage
^^^^^^^^^^^^^^

.. container:: table-row

  Property
    displayAsImage
    
  Data type
    Boolean
  
  Description
    If set, the check boxes are displayed as images instead of labels.

  Default
    1 


.. _Checkboxes.doNotDisplayIfNotChecked:

doNotDisplayIfNotChecked
^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

  Property
    doNotDisplayIfNotChecked
    
  Data type
    Boolean
  
  Description
    If set, do not display the check box value if it is not checked
    (obviously it does not apply when in edit mode).

  Default
    0


.. _Checkboxes.nbItems:

nbItems
^^^^^^^

.. container:: table-row

  Property
    nbItems
    
  Data type
  Integer

  Description
    Number of items to display.



