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



Checkbox: simple checkbox
-------------------------

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`Checkbox.checkboxSelectedImage`                   String                   Yes  Yes
:ref:`Checkbox.checkboxNotSelectedImage`                String                   Yes  Yes
:ref:`Checkbox.displayAsImage`                          Boolean     1            Yes  Yes
:ref:`Checkbox.doNotDisplayIfNotChecked`                Boolean     0            Yes  Yes
======================================================= =========== ============ ==== ====


.. _Checkbox.checkboxSelectedImage:
         
checkboxSelectedImage
^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

  Property
    checkboxSelectedImage

  Data type
    String
   
  Description
    The string is used as a file name which is searched in the icon
    directory. It replaces the default image for a selected checkbox.

  
 
.. _Checkbox.checkboxNotSelectedImage:

checkboxNotSelectedImage
^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

  Property
    checkboxNotSelectedImage
    
  Data type
    String
     
  Description
    The string is used as a file name which is searched in the icon
    directory. It replaces the default image for an unselected checkbox.

  
.. _Checkbox.displayAsImage:

displayAsImage
^^^^^^^^^^^^^^

.. container:: table-row

  Property
    displayAsImage
  
  Data type
    Boolean

  Description
    If set, the check box is displayed as an image instead of a label.    
     
  Default
    1


.. _Checkbox.doNotDisplayIfNotChecked:

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



