# Water Billing System

## Project Overview
The Water Billing System is a comprehensive solution designed to streamline and automate the billing processes of water utility providers. This project aims to enhance access to water by offering a robust platform for managing billing and payment services, ensuring efficient operations for community services, establishments, and organizations.

## Technologies Used
- PHP: Server-side scripting
- JavaScript: Client-side scripting
- jQuery: JavaScript library for DOM manipulation and AJAX
- Tailwind CSS: Utility-first CSS framework for styling
- MySQL: Database management

## Features
- User-friendly interface for both administrators and customers.
- Automated billing calculations based on water usage.
- Secure login and user management system.
- Payment gateway integration for easy bill settlements.
- Data analytics for usage patterns and financial reporting.

## Setup and Installation
1. Clone the repository to your local machine.
2. Set up a MySQL database and import the provided SQL schema.
3. Configure your PHP environment:
   - Edit the `php.ini` file to enable extensions required by `dompdf`. Specifically, ensure the following lines are uncommented:
     ```
     extension=mbstring
     extension=gd
     ```
     This will enable multibyte string processing and image processing capabilities which are necessary for PDF generation.
   - Connect the application to the database by editing the appropriate configuration files.
4. Install necessary JavaScript and CSS dependencies.
5. Run the system on a local server or deploy to a live server.

## Usage
After setting up the project, navigate to the homepage and log in with your credentials. Administrators can manage billing cycles, user data, and view reports. Customers can check their bill status, usage history, and make payments online.

## Contributing
Contributions to the Water Billing System are welcome. Please fork the repository and submit a pull request with your proposed changes.

## License
This project is licensed under the MIT License - see the LICENSE.md file for details.

## Acknowledgements
- Faculty of Information System Department
- Bachelor of Science in Information Systems

## Contact
- Jeffry James M. Paner - [panerjeffryjames@gmail.com]

---
For any additional information or support, please contact one of the contributors above.
