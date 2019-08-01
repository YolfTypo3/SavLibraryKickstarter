.. include:: ../../Includes.txt

.. _showOnly:

=========
Show Only
=========

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`showOnly.updateShowOnlyField`                     Boolean     0            Yes  No
======================================================= =========== ============ ==== ====

.. _showOnly.updateShowOnlyField:

updateShowOnlyField
===================
   
.. container:: table-row

  Property
    updateShowOnlyField
  
  Data type
    Boolean

  Description
    Show only field are not created nor can be updated. In some cases this default behavior must be
    overridden, for example when the field comes from an existing table. Settin this property to 1
    makes it possible to update a show only field (See :ref:`Example 8 <savlibraryplus:tutorial8>` or 
    :ref:`Example 10 <savlibraryplus:tutorial8>` in the tutorial section of SAV Library Plus).
   
  Default
    0