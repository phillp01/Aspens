Aspens Interview Task 1
===================

**Problem**

We have just received a requirement from a client where we need to import and upload a CSV file of students into an Aspens Controlled system and then searched. This list of students (once imported) needs to be able to be searched by student name and class name. This is to allow them to create print outs of various student information based upon that search criteria.


As this task was fairly open to interpretation I decided to approach it by creating a bare bones system that allowd a user to populate a MySQL database using a CSV upload and then had a couple of boxes available to search the requested criteria.
Based on the fact that a LAMP server was in use I assumed that the data was destined for a MySQL DB and have written as such.
Given some more time to play with this I would create a dropdown selection box on the search field for class or potentially Auto fill as they type.

A database called 'Aspens' will need to be created and the .sql script can then be applied to create the required schema.
Once this is done the relevant credentials need to be added to the dbConnect.php file.


A working version of this can bee seen at : **http://www.paulphillips.co.uk/aspens**


# Aspens
