# MonthsDate
## Display date with month name
### Snippet for Evolution CMS
based on aDate snippet https://github.com/extras-evolution/aDate 

- rewritten  for PHP 8 (replaced deprecated strftime with DateTime)
- added multilanguage support (aDate was only for russian)
- added 8 languages: de, en, es, fr, it, nl, ru, uk. 
- added Template Variables support

### Usage:

``` [[MonthsDate? &outFormat=`%d% %m% %y%` &lang=`it` &date=`[*pub_date*]` &date2=`[*pub_date*]`]]  ```

``` [[MonthsDate? &date=`[*createdon*]`]]  ```  // System date

``` [[MonthsDate? &date=`[*tv_data*]`]]  ```    // Template Variable

``` [[MonthsDate? &date=`2024-12-24`]]  ```     // Formatted date
