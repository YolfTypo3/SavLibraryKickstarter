.. include:: ../../Includes.txt

.. _selectorbox:

===========
Selectorbox
===========

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`selectorbox.func`                                 Integer                  Yes  No
:ref:`selectorbox.separator`                            String                   Yes  No
======================================================= =========== ============ ==== ====


.. _selectorbox.func:

func
====

.. container:: table-row

    Property
        func

    Data type
        Function name
  
    Description
        It associates a function with the selectorbox items. The parameter
        ``function_name`` can be:
             
        - makeItemLink
             
        - makeExtLink
             
        - makeLink
             
        - makeUrlLink
             
        - makeEmailLink
             
        See :ref:`functions` for the associated parameters .
 

.. _selectorbox.separator:

separator
=========

.. container:: table-row

    Property
        separator
             
    Data type
        character or string        
   
    Description
        It can be used with selector boxes associated with a MM relation to
        replace the default <br /> separator between items in showAll or
        showSingle views.