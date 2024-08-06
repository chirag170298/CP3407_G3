"""
Please ensure you have mysql installed for python, install command is-
pip install mysql-connector-python

This code will test our DB to make sure it can add values successfully to all tables,
then remove the added values afterwards

"""


import mysql.connector
from mysql.connector import Error

USERID = 8888
USERNAME = 'Testuser1'
PASSWORD = 'Password1'
PERSONID = 9999
FIRSTNAME = 'John'
LASTNAME = 'Doe'
STOREID = 1
NEW_ROLEID = 4
ROLEID = 1
SALEID = 1000
SALEDATE = '2024-08-01'
IDHR = 1
POLICY_COMPLETED = 'Yes'
INVOICEID = 1000
INVOICEDATE = '2024-08-01'
TOTALAMOUNT = 100.00
INVOICEDETAILID = 2000
STOCK_ID = 100
INVOICE_QUANTITY = 1
INVOICE_PRICE = 10
FEEDBACK = 'Good'
TASKS_COMPLETED = 5
ATTENDANCE = 100
EFFICIENCY = 90
TRAINING_COMPLETED = 2
PROMOTIONAL_ID = 12
PROMOTION_NAME = "End of summer sale"
PROMOTION_DESCRIPTION = "Discount on beach gear"
PROMOTION_START_DATE = '2024-07-01'
PROMOTION_END_DATE = '2024-07-31'
PROMOTION_IMAGE = 'image.jpg'
ROLE_DESCRIPTION = "District Manager"
ROSTER_ID = 1
ROSTER_DATE = '2024-08-06'
SHIFT_ID = 2000
SUPPLIER_ID = 1
SUPPLIER_NAME = 'Bega'
SUPPLIER_EMAIL = 'customersupport@bega.com.au'
SUPPLIER_CONTACT_NUM = '1800 003 002'
ITEM_NAME = 'Cheesecake'
COUNT_QTY= 1000
ITEM_PRICE = 15.05
CATEGORY_TYPE = "dessert"
UNIT_OF_SALE = "Slice"
SHIFT_TYPE = "Test Shift"
NEW_STORE_ID = 2
STORE_NAME = "Second Main store"
TIMESHEET_ID = 100
CLOCK_IN = '08:00:00'
CLOCK_OUT = '16:00:00'


try:
    # Connect to the database
    connection = mysql.connector.connect(
        host='cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com',
        user='CP3407admin',
        password='YFtG]?$4&+k}.WJ',
        database='EasyGrocer'
    )

    if connection.is_connected():
        cursor = connection.cursor()

        # Insert values
        insert_queries = [
            f"INSERT INTO users (id, username, password) VALUES ({USERID}, '{USERNAME}', '{PASSWORD}')",
            f"INSERT INTO Person (PersonID, FirstName, LastName, StoreID, RoleID, users_id) VALUES ({PERSONID}, '{FIRSTNAME}', '{LASTNAME}', {STOREID}, {ROLEID}, {USERID})",
            f"INSERT INTO Sales (SaleID, SaleDate, PersonID) VALUES ({SALEID}, '{SALEDATE}', {PERSONID})",
            f"INSERT INTO HR (idHR, POLICY_COMPLETED, Store_StoreID) VALUES ({IDHR}, '{POLICY_COMPLETED}', {STOREID})",
            f"INSERT INTO SUPPLIER (SUPPLIER_ID, SUPPLIER_NAME, SUPPLIER_EMAIL, SUPPLIER_CONTACT_NUM) VALUES ({SUPPLIER_ID}, '{SUPPLIER_NAME}', '{SUPPLIER_EMAIL}', '{SUPPLIER_CONTACT_NUM}')",
            f"INSERT INTO STOCK (STOCK_ID, ITEM_NAME, COUNT_QTY, PRICE, Store_StoreID, category_Type, UOS, SUPPLIER_SUPPLIER_ID) VALUES ({STOCK_ID}, '{ITEM_NAME}', {COUNT_QTY}, {ITEM_PRICE}, {STOREID}, '{CATEGORY_TYPE}', '{UNIT_OF_SALE}', {SUPPLIER_ID})",
            f"INSERT INTO Invoice (InvoiceID, SaleID, InvoiceDate, TotalAmount) VALUES ({INVOICEID}, {SALEID}, '{INVOICEDATE}', {TOTALAMOUNT})",
            f"INSERT INTO InvoiceDetails (InvoiceDetailID, InvoiceID, STOCK_ID, Quantity, Price) VALUES ({INVOICEDETAILID}, {INVOICEID}, {STOCK_ID}, {INVOICE_QUANTITY}, {INVOICE_PRICE})",
            f"INSERT INTO PERFORMANCE (PersonID, FEEDBACK, TASKS_COMPLETED, ATTENDANCE, EFFICIENCY, TRAINING_COMPLETED) VALUES ({PERSONID}, '{FEEDBACK}', {TASKS_COMPLETED}, {ATTENDANCE}, {EFFICIENCY}, {TRAINING_COMPLETED})",
            f"INSERT INTO PROMOTIONAL (PROMOTIONAL_ID, PROMOTION_NAME, DESCRIPTION, START_DATE, END_DATE, IMAGE) VALUES ({PROMOTIONAL_ID}, '{PROMOTION_NAME}', '{PROMOTION_DESCRIPTION}', '{PROMOTION_START_DATE}', '{PROMOTION_END_DATE}', '{PROMOTION_IMAGE}')",
            f"INSERT INTO Role (RoleID, RoleName) VALUES ({NEW_ROLEID}, '{ROLE_DESCRIPTION}')",
            f"INSERT INTO Shift (ShiftID, ShiftType) VALUES ({SHIFT_ID}, '{SHIFT_TYPE}')",
            f"INSERT INTO Roster (RosterID, Date, ShiftID, users_id) VALUES ({ROSTER_ID}, '{ROSTER_DATE}', {SHIFT_ID}, {USERID})",
            f"INSERT INTO Store (StoreID, StoreName) VALUES ({NEW_STORE_ID}, '{STORE_NAME}')",
            f"INSERT INTO TIMESHEET (TIMESHEET_ID, Roster_RosterID, CLOCK_IN, CLOCK_OUT) VALUES ({TIMESHEET_ID}, {ROSTER_ID}, '{CLOCK_IN}', '{CLOCK_OUT}')",
        ]

        for query in insert_queries:
            cursor.execute(query)
            print(f"{query}")
            print("Record inserted successfully.")
        connection.commit()


        # Delete values
        delete_queries = [
            f"DELETE FROM HR WHERE idHR = {IDHR}",
            f"DELETE FROM InvoiceDetails WHERE InvoiceDetailID = {INVOICEDETAILID}",
            f"DELETE FROM Invoice WHERE InvoiceID = {INVOICEID}",
            f"DELETE FROM PERFORMANCE WHERE PersonID = {PERSONID}",
            f"DELETE FROM PROMOTIONAL WHERE PROMOTIONAL_ID = {PROMOTIONAL_ID}",
            f"DELETE FROM Role WHERE RoleID = {NEW_ROLEID}",
            f"DELETE FROM TIMESHEET WHERE TIMESHEET_ID = {TIMESHEET_ID}",

            f"DELETE FROM Roster WHERE RosterID = {ROSTER_ID}",
            f"DELETE FROM STOCK WHERE STOCK_ID = {STOCK_ID}",
            f"DELETE FROM SUPPLIER WHERE SUPPLIER_ID = {SUPPLIER_ID}",
            f"DELETE FROM Sales WHERE SaleID = {SALEID}",
            f"DELETE FROM Shift WHERE ShiftID = {SHIFT_ID}",
            f"DELETE FROM Person WHERE PersonID = {PERSONID}",
            f"DELETE FROM Store WHERE StoreID = {NEW_STORE_ID}",
            f"DELETE FROM users WHERE id = {USERID}"

        ]


        for query in delete_queries:
            cursor.execute(query)
            print(f"{query}")
            print("Record deleted successfully.")

        connection.commit()

except Error as e:
    print("Error:", e)

finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("MySQL connection is closed")
