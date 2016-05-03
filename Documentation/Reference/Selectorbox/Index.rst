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


Selectorbox
-----------


======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`Selectorbox.func`                                 Integer                  Yes  No
:ref:`Selectorbox.separator`                            String                   Yes  No
======================================================= =========== ============ ==== ====


.. _Selectorbox.func:

func
^^^^

.. container:: table-row

    Property
        func

    Data type
        Function name
  
    Description
        It associates a function with the selectorbox items. The parameter
        function\_name can be:
             
        - makeItemLink
             
        - makeExtLink
             
        - makeLink
             
        - makeUrlLink
             
        - makeEmailLink
             
        See :ref:`functions` for the associated parameters .
 

.. _Selectorbox.separator:

separator
^^^^^^^^^

.. container:: table-row

    Property
        separator
             
    Data type
        character or string        
   
    Description
        It can be used with selector boxes associated with a MM relation to
        replace the default <br /> separator between items in showAll or
        showSingle views.





