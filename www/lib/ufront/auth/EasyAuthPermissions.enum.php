<?php

class ufront_auth_EasyAuthPermissions extends Enum {
	public static $EAPAssignAnyGroup;
	public static $EAPAssignAnyUserPermission;
	public static $EAPAssignOwnGroup;
	public static $EAPAssignUserPermissionYouHave;
	public static $EAPCanDoAnything;
	public static $EAPChangePasswordAnyUser;
	public static $EAPChangePasswordOwnUser;
	public static $EAPCreateGroup;
	public static $EAPCreateUser;
	public static $EAPEditAnyGroup;
	public static $EAPEditAnyUser;
	public static $EAPEditOwnGroup;
	public static $EAPEditOwnUser;
	public static $EAPListAllGroups;
	public static $EAPListAllUsers;
	public static $EAPListGroupsForUser;
	public static $EAPListUserPermissions;
	public static $EAPListUsersInGroups;
	public static $__constructors = array(8 => 'EAPAssignAnyGroup', 10 => 'EAPAssignAnyUserPermission', 7 => 'EAPAssignOwnGroup', 9 => 'EAPAssignUserPermissionYouHave', 17 => 'EAPCanDoAnything', 14 => 'EAPChangePasswordAnyUser', 13 => 'EAPChangePasswordOwnUser', 6 => 'EAPCreateGroup', 5 => 'EAPCreateUser', 16 => 'EAPEditAnyGroup', 12 => 'EAPEditAnyUser', 15 => 'EAPEditOwnGroup', 11 => 'EAPEditOwnUser', 1 => 'EAPListAllGroups', 0 => 'EAPListAllUsers', 3 => 'EAPListGroupsForUser', 2 => 'EAPListUserPermissions', 4 => 'EAPListUsersInGroups');
	}
ufront_auth_EasyAuthPermissions::$EAPAssignAnyGroup = new ufront_auth_EasyAuthPermissions("EAPAssignAnyGroup", 8);
ufront_auth_EasyAuthPermissions::$EAPAssignAnyUserPermission = new ufront_auth_EasyAuthPermissions("EAPAssignAnyUserPermission", 10);
ufront_auth_EasyAuthPermissions::$EAPAssignOwnGroup = new ufront_auth_EasyAuthPermissions("EAPAssignOwnGroup", 7);
ufront_auth_EasyAuthPermissions::$EAPAssignUserPermissionYouHave = new ufront_auth_EasyAuthPermissions("EAPAssignUserPermissionYouHave", 9);
ufront_auth_EasyAuthPermissions::$EAPCanDoAnything = new ufront_auth_EasyAuthPermissions("EAPCanDoAnything", 17);
ufront_auth_EasyAuthPermissions::$EAPChangePasswordAnyUser = new ufront_auth_EasyAuthPermissions("EAPChangePasswordAnyUser", 14);
ufront_auth_EasyAuthPermissions::$EAPChangePasswordOwnUser = new ufront_auth_EasyAuthPermissions("EAPChangePasswordOwnUser", 13);
ufront_auth_EasyAuthPermissions::$EAPCreateGroup = new ufront_auth_EasyAuthPermissions("EAPCreateGroup", 6);
ufront_auth_EasyAuthPermissions::$EAPCreateUser = new ufront_auth_EasyAuthPermissions("EAPCreateUser", 5);
ufront_auth_EasyAuthPermissions::$EAPEditAnyGroup = new ufront_auth_EasyAuthPermissions("EAPEditAnyGroup", 16);
ufront_auth_EasyAuthPermissions::$EAPEditAnyUser = new ufront_auth_EasyAuthPermissions("EAPEditAnyUser", 12);
ufront_auth_EasyAuthPermissions::$EAPEditOwnGroup = new ufront_auth_EasyAuthPermissions("EAPEditOwnGroup", 15);
ufront_auth_EasyAuthPermissions::$EAPEditOwnUser = new ufront_auth_EasyAuthPermissions("EAPEditOwnUser", 11);
ufront_auth_EasyAuthPermissions::$EAPListAllGroups = new ufront_auth_EasyAuthPermissions("EAPListAllGroups", 1);
ufront_auth_EasyAuthPermissions::$EAPListAllUsers = new ufront_auth_EasyAuthPermissions("EAPListAllUsers", 0);
ufront_auth_EasyAuthPermissions::$EAPListGroupsForUser = new ufront_auth_EasyAuthPermissions("EAPListGroupsForUser", 3);
ufront_auth_EasyAuthPermissions::$EAPListUserPermissions = new ufront_auth_EasyAuthPermissions("EAPListUserPermissions", 2);
ufront_auth_EasyAuthPermissions::$EAPListUsersInGroups = new ufront_auth_EasyAuthPermissions("EAPListUsersInGroups", 4);
