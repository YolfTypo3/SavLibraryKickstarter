.. include:: ../../Includes.txt

.. _checkbox:

=========================
Checkbox: Simple Checkbox
=========================

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`checkbox.checkboxSelectedImage`                   String                   Yes  Yes
:ref:`checkbox.checkboxNotSelectedImage`                String                   Yes  Yes
:ref:`checkbox.displayAsImage`                          Boolean     1            Yes  Yes
:ref:`checkbox.doNotDisplayIfNotChecked`                Boolean     0            Yes  Yes
======================================================= =========== ============ ==== ====


.. _checkbox.checkboxSelectedImage:
         
checkboxSelectedImage
=====================

.. container:: table-row

  Property
    checkboxSelectedImage

  Data type
    String
   
  Description
    The string is used as a file name which is searched in the icon
    directory. It replaces the default image for a selected checkbox.

  
 
.. _checkbox.checkboxNotSelectedImage:

checkboxNotSelectedImage
========================

.. container:: table-row

  Property
    checkboxNotSelectedImage
    
  Data type
    String
     
  Description
    The string is used as a file name which is searched in the icon
    directory. It replaces the default image for an unselected checkbox.

  
.. _checkbox.displayAsImage:

displayAsImage
==============

.. container:: table-row

  Property
    displayAsImage
  
  Data type
    Boolean

  Description
    If set, the check box is displayed as an image instead of a label.    
     
  Default
    1


.. _checkbox.doNotDisplayIfNotChecked:

doNotDisplayIfNotChecked
========================

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