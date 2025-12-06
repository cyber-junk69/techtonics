// Shared utility script for accessing user data across all pages
// Include this script in all pages: <script src="shared.js"></script>

// Global variables accessible from all pages that include this script
let userName = localStorage.getItem('userName') || '';
let userRole = localStorage.getItem('userRole') || '';

/**
 * Get the stored username
 * @returns {string} The username from localStorage
 */
function getUserName() {
  return localStorage.getItem('userName') || '';
}

/**
 * Get the stored user role
 * @returns {string} The user role (Customer or Helper)
 */
function getUserRole() {
  return localStorage.getItem('userRole') || '';
}

/**
 * Update the username
 * @param {string} name - The new username to store
 */
function setUserName(name) {
  userName = name;
  localStorage.setItem('userName', name);
}

/**
 * Update the user role
 * @param {string} role - The new user role to store
 */
function setUserRole(role) {
  userRole = role;
  localStorage.setItem('userRole', role);
}

/**
 * Clear all user data
 */
function clearUserData() {
  userName = '';
  userRole = '';
  localStorage.removeItem('userName');
  localStorage.removeItem('userRole');
}
