# 🛠️ Mysqlinfo - MySQL Performance Monitoring & Query Insights for Laravel  

<p align="center">
  <img src="https://raw.githubusercontent.com/dhanikk/mysqlinfo/main/assets/mysql-preview.png" alt="mysqlinfo" width="100%" height="100%">
</p>
 

The **mysqlinfo** package provides valuable insights into your MySQL database, such as connection details, table sizes, row counts, indexes, and query performance. This package is designed to help you monitor and troubleshoot database issues by logging queries, execution times, and analyzing server status. Additionally, it tracks schema details like table collations and supported character sets to ensure efficient database management and query execution.  

## **⚠️ Security Warning**
This package does not include any built-in security measures and is intended for admin use only. It exposes sensitive database details and query execution data, which could pose a security risk if accessed by unauthorized users.Ensure that this package is only used in a secure environment and not exposed to public or unauthorized access. 

<p>🏷️ 
<a href="https://packagist.org/search/?tags=mysql" target="_blank" rel="noopener noreferrer">#MySQL</a>&nbsp;  
<a href="https://packagist.org/search/?tags=database" target="_blank" rel="noopener noreferrer">#Database</a>&nbsp;  
<a href="https://packagist.org/search/?tags=performance-monitoring" target="_blank" rel="noopener noreferrer">#PerformanceMonitoring</a>&nbsp;  
<a href="https://packagist.org/search/?tags=laravel" target="_blank" rel="noopener noreferrer">#Laravel</a>&nbsp;  
<a href="https://packagist.org/search/?tags=php" target="_blank" rel="noopener noreferrer">#PHP</a>&nbsp;  
<a href="https://packagist.org/search/?tags=query-optimization" target="_blank" rel="noopener noreferrer">#QueryOptimization</a>&nbsp;  
<a href="https://packagist.org/search/?tags=mysql-admin" target="_blank" rel="noopener noreferrer">#MySQLAdmin</a>&nbsp;  
<a href="https://packagist.org/search/?tags=server-monitoring" target="_blank" rel="noopener noreferrer">#ServerMonitoring</a>&nbsp;  
<a href="https://packagist.org/search/?tags=devops" target="_blank" rel="noopener noreferrer">#DevOps</a>&nbsp;  
<a href="https://packagist.org/search/?tags=database-management" target="_blank" rel="noopener noreferrer">#DatabaseManagement</a>  
</p> 

## Documentation
- [Features](#features)
- [Supported Versions](#supported-versions)
- [Installation](#installation)
    - [Commands](#commands)
        - [Vendor Publish](#vendor-publish)
        - [Accessing the Plugin](#accessing-the-plugin)
- [FAQs](#faqs)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security-vulnerabilities)
- [License](#license)
- [Testing](#testing)
- [Support](#get-support)

## **Features:**  
- **Real-time MySQL Performance Monitoring** – Track live database performance and query execution.  
- **Database Connection Insights** – View connection details, active users, and session statistics.  
- **Table & Index Analysis** – Monitor table sizes, row counts, indexes, and schema details.  
- **Slow Query Detection** – Identify and optimize slow-running queries for better efficiency.  
- **Query Execution Logging** – Log executed queries, their execution time, and performance impact.  
- **Storage & Fragmentation Optimization** – Detect fragmented tables and optimize storage.  
- **InnoDB Buffer & Cache Analysis** – Monitor buffer pool usage and cache efficiency.  
- **Query Load Monitoring** – Analyze query load in real-time and track database stress.  
- **Laravel Log Integration** – Store query performance logs for historical analysis.  
- **Security & Access Control** – Restrict access to database insights for admin use only.  


# **Supported Versions:**  
- **PHP:** ^8.0  
- **Illuminate Support:** ^9.0 | ^10.0 | ^11.0  

## **Installation**  
To install the package Open the terminal and run the following command:  
<pre><code class="language-bash">composer require itpathsolutions/mysqlinfo</code></pre>   

## **Commands**   

### **Vendor Publish**  
Run the following command to publish the vendor files:  
<pre><code class="language-bash">php artisan vendor:publish</code></pre>  

## **Accessing the Plugin**  
Once installed, open the following URL in your browser to check the plugin:  
<pre><code class="language-bash">localhost:8000/mysql-info</code></pre>  


## **FAQs**  

### 1️. What does this package do?  
This package provides real-time insights into your MySQL database, including connection details, table sizes, row counts, indexes, query performance, and server status. It helps monitor and optimize database performance.  

## 2. How do I install the package?  
📦 Installing is simple! Run the following command in your terminal:  
<pre><code class="language-bash">composer require itpathsolutions/mysqlinfo</code></pre>  

## 3. Which Laravel versions are supported?  
This package supports **Laravel 9, 10, and 11** with **PHP 8+** compatibility.  

## 4. How do I access MySQL insights?  
You can access MySQL performance insights via:  
👉 `localhost:8000/mysql-info`  

## 5. How do I update the package to the latest version?  
Run the following command to update:  
<pre><code class="language-bash">composer update itpathsolutions/mysqlinfo</code></pre>  

## 6. Can I contribute to this package?  
🤝 Absolutely! Contributions are welcome. See the [CONTRIBUTING](https://github.com/dhanikk/mysqlinfo/blob/main/CONTRIBUTING.md) guidelines for details.  

## 7. Where can I get support?  
For any support or queries, contact us via [IT Path Solutions](https://www.itpathsolutions.com/contact-us/).  


## **Contributing**  
We welcome contributions from the community! Feel free to **Fork** the repository and contribute to this module. You can also create a pull request, and we will merge your changes into the main branch. See <a href="https://github.com/dhanikk/mysqlinfo/blob/main/CONTRIBUTING.md" target="_blank" rel="noopener noreferrer">CONTRIBUTING</a> for details.  

## **Security Vulnerabilities**  
Please review our <a href="https://github.com/dhanikk/mysqlinfo/blob/main/security/policy" target="_blank" rel="noopener noreferrer">Security Policy</a> on how to report security vulnerabilities.  

## **License**  
This package is open-source and available under the MIT License. See the <a href="https://github.com/dhanikk/mysqlinfo/blob/main/LICENSE" target="_blank" rel="noopener noreferrer">LICENSE</a> file for details.  

## **Testing**  
To test this package, run the following test command:  
<pre><code class="language-bash">composer test</code></pre>   

## **Get Support**  
- Feel free to <a href="https://www.itpathsolutions.com/contact-us/" target="_blank" rel="noopener noreferrer">contact us</a> if you have any questions.  
- If you find this project helpful, please give us a ⭐ <a href="https://github.com/dhanikk/mysqlinfo/stargazers" target="_blank" rel="noopener noreferrer">Star</a>.  

## **You may also find our other useful package:**  
<a href="https://packagist.org/packages/itpathsolutions/phpinfo" target="_blank">PHP Info Package 🚀</a>  
<a href="https://packagist.org/packages/itpathsolutions/authinfo" target="_blank">AUTH Info Package 🚀</a>
<a href="https://packagist.org/packages/itpathsolutions/role-wise-session-manager" target="_blank">Role Wise Session Manager Package 🚀</a>
<a href="https://packagist.org/packages/itpathsolutions/chatbot" target="_blank">Chatbot Package 🚀</a>  