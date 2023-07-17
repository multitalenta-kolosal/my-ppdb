# Archounting

IMPORTANT:
DISCOUNT_TO_DP is used when changing important discount things

//Trial balance could lead to general ledger from former financial year


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

