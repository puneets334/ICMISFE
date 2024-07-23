# ICMIS v2 Development Protocols
**1. Technologies to be used:**<br>
- a. PHP Framework: CodeIgniter4 version 4.4.0<br>
- b. Database: PostgreSQL version 15<br>
- c. Javascript: JQuery/AngularJS<br>
- d. CSS: Bootstrap 5, AdminLTE3<br>

**2. Subversion of code using Gitlab installed on local network**<br>
**3. Containerization of project using Docker**<br>
**4. CodeIgniter4 logger to be used for file system based logging of events**<br>
**5. Validations on input data to be done both at client and server end**<br>
**6. Transactions to be used wherever insert, update or delete operations are performed on the database.**<br>
**7. For all master tables, JSON files are to be created which are to be placed in a single directory which is available throughout the application.**<br>
**8. Modularization of code to be done so as to avoid redoing the same work at multiple places.**<br>
**9. Code utilities such as functions to display alert, success or error message, email or sms etc. to be placed in common file (app/Common.php)**<br>
**10. PDO is to be used for connection to database server.**<br>
**11. Sensitive data such as mobile number and email to be encrypted.**<br>
**12. Proper naming conventions must be used in application.**<br>
- All JSONs created for master tables to have the same name as of the table
- Modelling of data to be done using Entity classes. These classes are to be created for all tables for simplifying the insertion and updation of data in transaction tables. These classes to have same name as tablename with ‘Model’ appended to it. For example users table can be modelled in class named as UserModel.
- All methods to be created using snake case and all variables to be created using camel case.

**13. All constants to be defined in .env and accessed via env() function of CI4. Do not declare constants in constants.php**<br>
**14.All tables to have entity classes defined for them. This will ease tasks of Database operations. Please refer given link**<br>
   https://www.codeigniter.com/user_guide/models/entities.html#entity-usage

**15. Code to be documented, briefly describing the task performed by that function/method**<br>
**16. Indentation of code to increase readability of code**<br>
**17. Code not in use shall be removed and not commented. (This has to be ensured before any code is committed.)**<br>

