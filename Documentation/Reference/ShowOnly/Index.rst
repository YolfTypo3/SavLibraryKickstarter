.. include:: ../../Includes.txt

.. _showOnly:

=========
Show Only
=========

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`showOnly.renderAs`                                String                   No  Yes
:ref:`showOnly.updateShowOnlyField`                     Boolean     0            Yes  Yes
======================================================= =========== ============ ==== ====

.. _showOnly.renderAs:

renderAs
========
   
.. container:: table-row

  Property
    renderAs
  
  Data type
    String

  Description
    In some cases the rendering type defined by the selector for ShowOnly field must be overridden.
    This property sets the rendering to the provided type, e.g. String. 
     
    
.. _showOnly.updateShowOnlyField:

updateShowOnlyField
===================
   
.. container:: table-row

  Property
    updateShowOnlyField
  
  Data type
    Boolean

  Description
    ShowOnly field are not created nor can be updated. In some cases this default behavior must be
    overridden, for example when the field comes from an existing table. Settin this property to 1
    makes it possible to update a show only field (See :ref:`Example 8 <savlibraryplus:tutorial8>` or 
    :ref:`Example 10 <savlibraryplus:tutorial10>` in the tutorial section of SAV Library Plus).
   
  Default
    0