# MonthDate
## Display date with month name
### Snippet for Evolution CMS
based on aDate snippet https://github.com/extras-evolution/aDate 

- rewritten  for PHP 8 (replaced deprecated strftime with DateTime)
- added multilanguage support (aDate was only for russian)
- added 8 languages: de, en, es, fr, it, nl, ru, uk. 
- added Template Variables support

### Usage:

``` [[MonthDate? &outFormat=`%d% %m% %y%` &lang=`it` &date=`[*pub_date*]` &date2=`[*pub_date*]`]]  ```

``` [[MonthDate? &date=`[*createdon*]`]]  ```  // System date

``` [[MonthDate? &date=`[*tv_data*]`]]  ```    // Template Variable

``` [[MonthDate? &date=`2024-12-24`]]  ```     // Formatted date
