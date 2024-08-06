"""
Please ensure you have mysql installed for python, install command is-
pip install mysql-connector-python

This code will test our DB to make sure it can add values successfully to all tables,
then remove the added values afterwards

"""


import mysql.connector
from mysql.connector import Error

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

            "INSERT INTO Sales (SaleID, SaleDate, PersonID) VALUES (1000, '2024-08-01', 1006)",
            "INSERT INTO HR (idHR, POLICY_COMPLETED, Store_StoreID) VALUES (1, 'Yes', 1)",
            "INSERT INTO Invoice (InvoiceID, SaleID, InvoiceDate, TotalAmount) VALUES (1000, 1000, '2024-08-01', 100.00)",
            "INSERT INTO InvoiceDetails (InvoiceDetailID, InvoiceID, STOCK_ID, Quantity, Price) VALUES (1, 1, 10, 10, 10.00)",
            "INSERT INTO PERFORMANCE (PersonID, FEEDBACK, TASKS_COMPLETED, ATTENDANCE, EFFICIENCY, TRAINING_COMPLETED) VALUES (1006, 'Good', 5, 100, 90, 2)",
            "INSERT INTO PROMOTIONAL (PROMOTIONAL_ID, PROMOTION_NAME, DESCRIPTION, START_DATE, END_DATE, IMAGE) VALUES (12, 'End of Summer Sale', 'Discounts on summer items', '2024-07-01', '2024-07-31', 'image.jpg')",
            "INSERT INTO Person (PersonID, FirstName, LastName, StoreID, RoleID, users_id) VALUES (1, 'John', 'Doe', 1, 1, 1)",
            "INSERT INTO Role (RoleID, RoleName) VALUES (4, 'District Manager')",
            "INSERT INTO Roster (RosterID, Date, ShiftID, users_id) VALUES (1, '2024-08-01', 1, 1)",
            "INSERT INTO SUPPLIER (SUPPLIER_ID, SUPPLIER_NAME, SUPPLIER_EMAIL, SUPPLIER_CONTACT_NUM) VALUES (1, 'Supplier A', 'contact@suppliera.com', '1234567890')",
            "INSERT INTO STOCK (STOCK_ID, ITEM_NAME, COUNT_QTY, PRICE, Store_StoreID, category_Type, UOS, SUPPLIER_SUPPLIER_ID) VALUES (1, 'Item A', 100, 10.00, 1, 'Category A', 'Unit', 1)",
            "INSERT INTO Shift (ShiftID, ShiftType) VALUES (2000, 'Test shift')",
            "INSERT INTO Store (StoreID, StoreName) VALUES (2, 'Second Main Store')",
            "INSERT INTO TIMESHEET (TIMESHEET_ID, Roster_RosterID, CLOCK_IN, CLOCK_OUT) VALUES (1, 1, '08:00:00', '16:00:00')",
            "INSERT INTO users (id, username, password) VALUES (1010, 'TestUser1', 'password1')"
        ]

        for query in insert_queries:
            cursor.execute(query)
        connection.commit()
        print("Records inserted successfully.")

        # Delete values
        delete_queries = [
            "DELETE FROM HR WHERE idHR = 1",
            "DELETE FROM Invoice WHERE InvoiceID = 1000",
            "DELETE FROM InvoiceDetails WHERE InvoiceDetailID = 1",
            "DELETE FROM PERFORMANCE WHERE PersonID = 1006",
            "DELETE FROM PROMOTIONAL WHERE PROMOTIONAL_ID = 12",
            "DELETE FROM Person WHERE PersonID = 1",
            "DELETE FROM Role WHERE RoleID = 4",
            "DELETE FROM TIMESHEET WHERE TIMESHEET_ID = 1",

            "DELETE FROM Roster WHERE RosterID = 1",
            "DELETE FROM STOCK WHERE STOCK_ID = 1",
            "DELETE FROM SUPPLIER WHERE SUPPLIER_ID = 1",
            "DELETE FROM Sales WHERE SaleID = 1000",
            "DELETE FROM Shift WHERE ShiftID = 2000",
            "DELETE FROM Store WHERE StoreID = 2",
            "DELETE FROM users WHERE id = 1010"
        ]

        for query in delete_queries:
            cursor.execute(query)
        connection.commit()
        print("Records deleted successfully.")

except Error as e:
    print("Error:", e)

finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("MySQL connection is closed")
