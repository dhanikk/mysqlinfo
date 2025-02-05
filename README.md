# mysqlinfo  

The **mysqlinfo** package provides valuable insights into your MySQL database, such as connection details, table sizes, row counts, indexes, and query performance. This package is designed to help you monitor and troubleshoot database issues by logging queries, execution times, and analyzing server status. Additionally, it tracks schema details like table collations and supported character sets to ensure efficient database management and query execution.  

## **Features:**  
- **Real-time MySQL database performance monitoring.**  
- **View database connection details, table sizes, row counts, and indexes.**  
- **Track query performance and execution times.**  
- **Analyze server status and database schema details, including table collations and supported character sets.**  

# **Supported Versions:**  
- **PHP:** ^8.0  
- **Illuminate Support:** ^9.0 | ^10.0 | ^11.0  

## **Installation**  
To install the **mysqlinfo** package, follow these steps:  
    1. Open your terminal.   
    2. Run the following Composer command: **composer require itpathsolutions/mysqlinfo**  
    3. Write this command to publish the vendor: **php artisan vendor:publish**  
    4. Route: **localhost:8000/dashboard/database-info**   


## **Usage**  

Once the package is installed, navigate to **localhost:8000/dashboard/database-info** in your browser to view detailed database information. The page will display information such as database size, table data, query performance, and server status based on the logged information from the package.  

