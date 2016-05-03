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


Relation 1:n (Selectorbox) or relation n:n (Double selectorbox)
---------------------------------------------------------------



======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`Relation_1_n.aliasSelect`                         Field name               Yes  No
:ref:`Relation_1_n.additionalTableSelect`               String                   Yes  No
:ref:`Relation_1_n.applyFuncToRecords`                  Boolean     0            Yes  No
:ref:`Relation_1_n.groupBySelect`                       String                   Yes  No
:ref:`Relation_1_n.labelSelect`                         Field name               Yes  No
:ref:`Relation_1_n.orderSelect`                         String                   Yes  No
:ref:`Relation_1_n.overrideEnableFields`                Boolean     0            Yes  No
:ref:`Relation_1_n.overrideStartingPoint`               Boolean     0            Yes  No
:ref:`Relation_1_n.separator`                           String                   Yes  No
:ref:`Relation_1_n.singleWindow`                        Boolean     0            Yes  No
:ref:`Relation_1_n.specialFields`                       String                   Yes  No
:ref:`Relation_1_n.whereSelect`                         String                   Yes  No
======================================================= =========== ============ ==== ====


.. _Relation_1_n.additionalTableSelect:

additionalTableSelect
^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property 
        additionalTableSelect
   
    Data type
        String
                 
    Description
        The string is a comma-separated table names.
        It Adds the table names in the select query. It can be used when tables
        need to be joined.



.. _Relation_1_n.aliasSelect:

aliasSelect
^^^^^^^^^^^

.. container:: table-row

    Property 
        aliasSelect
   
    Data type
        Field name
                  
    Description
        Defines an alias used in the SELECT query. Markers ###fieldname### can
        be used, fieldname must be in the relation table.



.. _Relation_1_n.applyFuncToRecords:

applyFuncToRecords
^^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property 
        applyFuncToRecords
   
    Data type
        Boolean
                  
    Description
        If true the function defined by the “func” attribute is applied to
        each record of a double selector in the single view.

    Default
        0
  
  
.. _Relation_1_n.content:

content
^^^^^^^
.. container:: table-row

    Property 
        content       
   
    Data type
        SQL SELECT statement
 
    Description
        SQL SELECT statement must have an alias "uid" and an alias "label"
        which will be used as the value to display. Special markers can be
        used in the statement :
         
        - ###uid### will be replaced by the current record uid.
         
        - ###uidSelected### will be replaced by the selected item.
         
        - ###user### will be replaced by the user id.
         
        - ###cruser### will be replaced by the user id.
         
        The following example returns a selectorbox with the usernames that
        are linked with the user by a MM relation:
         
        ::
         
            content = 
            SELECT fe_users.uid as uid, fe_users.name as label 
            FROM tx_mytable_rel_myfield_mm,fe_users 
            WHERE tx_mytable_rel_myfields_mm.uid_local=###user###
            AND tx_mytable_rel_myfields_mm.uid_foreign=fe_users.uid
            ORDER by label;



.. _Relation_1_n.groupBySelect:

groupBySelect
^^^^^^^^^^^^^

.. container:: table-row

    Property 
        groupBySelect       
   
    Data type
        String
   
    Description
        Defines the GROUP BY clause for the selector.

  

.. _Relation_1_n.labelSelect:

labelSelect
^^^^^^^^^^^

.. container:: table-row

    Property 
        labelSelect       
   
    Data type
        Field name
 
    Description
        Defines the label from the field name for the selector.



.. _Relation_1_n.orderSelect:

orderSelect
^^^^^^^^^^^
 
.. container:: table-row

    Property 
        orderSelect

    Data type
        String  
                     
    Description
        Define the order clause for the selector. In general: fieldname
        [desc].
   



.. _Relation_1_n.overrideEnableFields:

overrideEnableFields
^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property 
        overrideEnableFields
   
    Data type
        Boolean
                   
    Description
        If set, the method enableFields of the class tslib\_cObj which filters
        out records with start/end times or hidden/fe\_groups fields is not
        applied to the query associated with the selectorbox.
         
        It may be used in specific cases when you needed to retreive all the
        records.
  
    Default
        0


.. _Relation_1_n.overrideStartingPoint:

overrideStartingPoint
^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property 
        overrideStartingPoint
        
    Data type
        Boolean   

    Description
        By default, when starting points are provided, information associated
        with the selector is searched in these page. This property overrides
        the default behavior. 
   
    Default
        0

.. _Relation_1_n.separator:

separator
^^^^^^^^^

.. container:: table-row

    Property 
        separator 
        
    Data type
        String 
                     
    Description
        It should be used when the max number of relations is greater than 1
        (not true MM-relation) to replace the default <br /> separator between
        items in showAll or showSingle views.
   


  
.. _Relation_1_n.singleWindow:

singleWindow
^^^^^^^^^^^^

.. container:: table-row

    Property 
        singleWindow
    
    Data type
        Boolean       

    Description
        In case of a MM relation, a double window is used to select items.
        When this option is used, a single selectorbox in multiple mode is
        used.
     
    Default
        0


.. _Relation_1_n.specialFields:

specialFields
^^^^^^^^^^^^^

.. container:: table-row

    Property 
        specialFields   
   
    Data type
        comma-separated list of fields
        
    Description
        The value of the fields will be propagated in the
        ###special[fieldname]### marker when available.



.. _Relation_1_n.whereSelect:

whereSelect
^^^^^^^^^^^

.. container:: table-row

    Property 
        whereSelect   

    Data type
        String
  
    Description
        Defines the WHERE clause for the selector. It can be:
         
        - a conventional MySQL clause.- The marker ###user### can be used. It
          will be replaced by the user uid.- The marker ###uid### can be used.
          it will be replaced by the main current record.- The marker
          ###CURRENT\_PID### can be used. It will be replaced by the current
          page uid.- The marker ###STORAGE\_PID### can be used. It will be
          replaced by the storage page uid.
         
        - ###group\_list = list\_of\_comma\_separed\_fe\_groups###. To be used
          with a selector on fe\_users. It checks if the user belongs to the
          group list.
         
        - ###group\_list != list\_of\_comma\_separed\_fe\_groups###. To be used
          with a selector on fe\_users. It checks if the user does not belong to
          the group list.
   









