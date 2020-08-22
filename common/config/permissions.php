<?php

/*
Example of permission:

action = controller.action (convention)
action_group = action group only to organize visually the permissions
description = Permission.Controller.Action (it will be translated using backend group)
status = Permission::STATUS_INACTIVE (default = STATUS_ACTIVE)

Obs: If you change this file, update permissions on settings menu from administration panel
*/

return ['permissions' =>
    [
        ['action_group' => 'Permission.ActionGroup.System', 'action' => 'site.index', 'description' => 'Permission.Site.Index'],
        ['action_group' => 'Permission.ActionGroup.System', 'action' => 'site.set-sidebar-menu-state', 'description' => 'Permission.Site.SetSidebarMenuState'],
        ['action_group' => 'Permission.ActionGroup.System', 'action' => 'settings.index', 'description' => 'Permission.Settings.Index'],
        ['action_group' => 'Permission.ActionGroup.System', 'action' => 'settings.update-permissions', 'description' => 'Permission.Settings.UpdatePermissions'],

        ['action_group' => 'Permission.ActionGroup.System', 'action' => 'menu.main', 'description' => 'Permission.Menu.Main'],
        ['action_group' => 'Permission.ActionGroup.System', 'action' => 'menu.report', 'description' => 'Permission.Menu.Report'],
        ['action_group' => 'Permission.ActionGroup.System', 'action' => 'menu.system', 'description' => 'Permission.Menu.System'],

        ['action_group' => 'Permission.ActionGroup.Profile', 'action' => 'profile.index', 'description' => 'Permission.Profile.Index'],
        ['action_group' => 'Permission.ActionGroup.Profile', 'action' => 'profile.avatar-upload', 'description' => 'Permission.Profile.AvatarUpload'],
        ['action_group' => 'Permission.ActionGroup.Profile', 'action' => 'profile.avatar-delete', 'description' => 'Permission.Profile.AvatarDelete'],

        ['action_group' => 'Permission.ActionGroup.User', 'action' => 'user.index', 'description' => 'Permission.User.Index'],
        ['action_group' => 'Permission.ActionGroup.User', 'action' => 'user.create', 'description' => 'Permission.User.Create'],
        ['action_group' => 'Permission.ActionGroup.User', 'action' => 'user.update', 'description' => 'Permission.User.Update'],
        ['action_group' => 'Permission.ActionGroup.User', 'action' => 'user.view', 'description' => 'Permission.User.View'],
        ['action_group' => 'Permission.ActionGroup.User', 'action' => 'user.delete', 'description' => 'Permission.User.Delete'],

        ['action_group' => 'Permission.ActionGroup.Group', 'action' => 'group.index', 'description' => 'Permission.Group.Index'],
        ['action_group' => 'Permission.ActionGroup.Group', 'action' => 'group.create', 'description' => 'Permission.Group.Create'],
        ['action_group' => 'Permission.ActionGroup.Group', 'action' => 'group.update', 'description' => 'Permission.Group.Update'],
        ['action_group' => 'Permission.ActionGroup.Group', 'action' => 'group.view', 'description' => 'Permission.Group.View'],
        ['action_group' => 'Permission.ActionGroup.Group', 'action' => 'group.delete', 'description' => 'Permission.Group.Delete'],

        ['action_group' => 'Permission.ActionGroup.Permission', 'action' => 'permission.index', 'description' => 'Permission.Permission.Index'],
        ['action_group' => 'Permission.ActionGroup.Permission', 'action' => 'permission.create', 'description' => 'Permission.Permission.Create'],
        ['action_group' => 'Permission.ActionGroup.Permission', 'action' => 'permission.update', 'description' => 'Permission.Permission.Update'],
        ['action_group' => 'Permission.ActionGroup.Permission', 'action' => 'permission.view', 'description' => 'Permission.Permission.View'],
        ['action_group' => 'Permission.ActionGroup.Permission', 'action' => 'permission.delete', 'description' => 'Permission.Permission.Delete'],

        ['action_group' => 'Permission.ActionGroup.Customer', 'action' => 'user.index', 'description' => 'Permission.User.Index'],
        ['action_group' => 'Permission.ActionGroup.Customer', 'action' => 'user.create', 'description' => 'Permission.User.Create'],
        ['action_group' => 'Permission.ActionGroup.Customer', 'action' => 'user.update', 'description' => 'Permission.User.Update'],
        ['action_group' => 'Permission.ActionGroup.Customer', 'action' => 'user.view', 'description' => 'Permission.User.View'],
        ['action_group' => 'Permission.ActionGroup.Customer', 'action' => 'user.delete', 'description' => 'Permission.User.Delete'],

        ['action_group' => 'Permission.ActionGroup.Content', 'action' => 'content.index', 'description' => 'Permission.Content.Index'],
        ['action_group' => 'Permission.ActionGroup.Content', 'action' => 'content.create', 'description' => 'Permission.Content.Create'],
        ['action_group' => 'Permission.ActionGroup.Content', 'action' => 'content.update', 'description' => 'Permission.Content.Update'],
        ['action_group' => 'Permission.ActionGroup.Content', 'action' => 'content.view', 'description' => 'Permission.Content.View'],
        ['action_group' => 'Permission.ActionGroup.Content', 'action' => 'content.delete', 'description' => 'Permission.Content.Delete'],
        ['action_group' => 'Permission.ActionGroup.Content', 'action' => 'content.get-images', 'description' => 'Permission.Content.GetImages'],
        ['action_group' => 'Permission.ActionGroup.Content', 'action' => 'content.upload-image', 'description' => 'Permission.Content.UploadImage'],

        ['action_group' => 'Permission.ActionGroup.Gallery', 'action' => 'gallery.index', 'description' => 'Permission.Gallery.Index'],
        ['action_group' => 'Permission.ActionGroup.Gallery', 'action' => 'gallery.create', 'description' => 'Permission.Gallery.Create'],
        ['action_group' => 'Permission.ActionGroup.Gallery', 'action' => 'gallery.update', 'description' => 'Permission.Gallery.Update'],
        ['action_group' => 'Permission.ActionGroup.Gallery', 'action' => 'gallery.view', 'description' => 'Permission.Gallery.View'],
        ['action_group' => 'Permission.ActionGroup.Gallery', 'action' => 'gallery.delete', 'description' => 'Permission.Gallery.Delete'],
        ['action_group' => 'Permission.ActionGroup.Gallery', 'action' => 'gallery.item-upload', 'description' => 'Permission.Gallery.ItemUpload'],
        ['action_group' => 'Permission.ActionGroup.Gallery', 'action' => 'gallery.item-delete', 'description' => 'Permission.Gallery.ItemDelete'],

        ['action_group' => 'Permission.ActionGroup.Preference', 'action' => 'preference.index', 'description' => 'Permission.Preference.Index'],
        ['action_group' => 'Permission.ActionGroup.Preference', 'action' => 'preference.update', 'description' => 'Permission.Preference.Update'],
        ['action_group' => 'Permission.ActionGroup.Preference', 'action' => 'preference.view', 'description' => 'Permission.Preference.View'],

        ['action_group' => 'Permission.ActionGroup.Log', 'action' => 'log.index', 'description' => 'Permission.Log.Index'],
        ['action_group' => 'Permission.ActionGroup.Log', 'action' => 'log.delete', 'description' => 'Permission.Log.Delete'],
        ['action_group' => 'Permission.ActionGroup.Log', 'action' => 'log.view', 'description' => 'Permission.Log.View'],

        ['action_group' => 'Permission.ActionGroup.Report', 'action' => 'reports.user-report.index', 'description' => 'Permission.Reports.UserReport.Index'],
        ['action_group' => 'Permission.ActionGroup.Report', 'action' => 'reports.customer-report.index', 'description' => 'Permission.Reports.CustomerReport.Index'],
    ]
];