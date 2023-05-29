# Archounting

IMPORTANT:
Error when if we setting the DP
DISCOUNT_TO_DP is used when changing important discount things

!!! its close, try to make the discount only applied as a subtractor to total not to item and then change the receivable. after that change the sales advance to the tax

Document Class having relation with:
DocumentTotal : every Total and subtotal(?)
DocumentItem : ledger of every item
DocumentItemTax : ledger of every item tax. 

Ledger connecter:
Document : the value of the total (if invoices is on the debited, bill vice versa)
DocumentTotal : the value of extra total (in this case is discount or DP)
DocumentItem : the value of every item account
DocumentItemTax : the value of every item tax acount 

Discovery:
The ledger should be updated on the observer of every item.

The sequence of creating Document:
Create Document
Create DocumentItem
Create DocumentTax
Create DocumentTotals

