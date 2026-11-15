<?php


class RBACSystem {

    private $rolePermissions = [];
    

    private $userRoles = [];

    public function __construct() {

        $this->rolePermissions = [
            'Admin'    => ['Create', 'View', 'Update', 'Delete'],
            'Manager'  => ['View', 'Update'],
            'Customer' => ['View']
        ];
    }


    public function assignRole($username, $role) {
        if (array_key_exists($role, $this->rolePermissions)) {
            $this->userRoles[$username] = $role;
            echo "[ASSIGNMENT SUCCESS] User '$username' assigned to role '$role'.\n";
        } else {
            echo "[ASSIGNMENT ERROR] Role '$role' does not exist.\n";
        }
    }


    public function checkPermission($username, $action, $resource = 'Account') {

        if (!isset($this->userRoles[$username])) {
            echo "[ACCESS DENIED] User '$username' is not registered in the system.\n";
            return false;
        }

        $userRole = $this->userRoles[$username];
        $allowedPermissions = $this->rolePermissions[$userRole];

        if (in_array($action, $allowedPermissions)) {
            echo "[ACCESS GRANTED] User '$username' ($userRole) -> Action '$action' on '$resource': ALLOWED\n";
            return true;
        } else {
            echo "[ACCESS DENIED] User '$username' ($userRole) -> Action '$action' on '$resource': DENIED\n";
            return false;
        }
    }
}



echo "\n";
echo "      ROLE-BASED ACCESS CONTROL (RBAC) SYSTEM - PHP DEMO\n";
echo "\n\n";

$rbac = new RBACSystem();


echo "1. ASSIGNING ROLES TO USERS:\n";
$rbac->assignRole("Alice", "Admin");
$rbac->assignRole("Bob", "Manager");
$rbac->assignRole("Charlie", "Customer");

echo "\n2. TESTING PERMISSIONS ON 'ACCOUNT' OBJECT:\n\n";


echo "--- Testing Alice (Admin Role) ---\n";
$rbac->checkPermission("Alice", "Create");
$rbac->checkPermission("Alice", "View");
$rbac->checkPermission("Alice", "Update");
$rbac->checkPermission("Alice", "Delete");


echo "\n--- Testing Bob (Manager Role) ---\n";
$rbac->checkPermission("Bob", "Create");
$rbac->checkPermission("Bob", "View");
$rbac->checkPermission("Bob", "Update");
$rbac->checkPermission("Bob", "Delete");


echo "\n--- Testing Charlie (Customer Role) ---\n";
$rbac->checkPermission("Charlie", "Create");
$rbac->checkPermission("Charlie", "View");
$rbac->checkPermission("Charlie", "Update");
$rbac->checkPermission("Charlie", "Delete");

?>