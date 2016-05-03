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


Relation n:n (subform)
----------------------



======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`Relation_n_n.addDelete`                           Boolean     0            Yes  Yes
:ref:`Relation_n_n.addSave`                             Boolean     0            Yes  Yes
:ref:`Relation_n_n.addUpDown`                           Boolean     0            Yes  Yes
:ref:`Relation_n_n.maxSubformItems`                     Integer     0            Yes  Yes
:ref:`Relation_n_n.noFirstLast`                         Boolean     0            Yes  Yes
:ref:`Relation_n_n.subformTitle`                        String                   Yes  Yes
======================================================= =========== ============ ==== ====


.. _Relation_n_n.addDelete:

addDelete
^^^^^^^^^

.. container:: table-row

  Property
    addDelete
    
  Data type
    Boolean
    
  Description
    A delete icon will be added in front of each item.

  Default
    0


.. _Relation_n_n.addSave:

addSave
^^^^^^^

.. container:: table-row

  Property
    addSave

  Data type
    Boolean
    
  Description
    A save button and an anchor will be added. It simplifies the saving
    when several items are in the subform and the height of an item is
    important.

  Default
    0


.. _Relation_n_n.addUpDown:

addUpDown
^^^^^^^^^

.. container:: table-row

  Property
    addUpDown

  Data type
    Boolean
    
  Description
    Two buttons (up and down) will be added. They can be used to
    reorganize the order of the subform items.

  Default
    0


.. _Relation_n_n.maxSubformItems:

maxSubformItems
^^^^^^^^^^^^^^^

.. container:: table-row

  Property
    addUpDown

  Data type
    Integer
    
  Description
    Number of items that will be displayed in the subform. All items are
    displayed if set to 0.

  Default
    0


.. _Relation_n_n.noFirstLast:

noFirstLast
^^^^^^^^^^^

.. container:: table-row

  Property
    noFirstLast  

  Data type
    Boolean
  
  Description
    First and last buttons in the browser associated with the subform will
    not be shown.

  Default
    0


.. _Relation_n_n.subformTitle:

subformTitle
^^^^^^^^^^^^

.. container:: table-row

  Property
    subformTitle  
  
  Data type
    String
    
  Description
    If set, the string will be displayed in the title bar of the subform.
    Localization tags and markers can be used. 




