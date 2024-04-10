export const translateRoles = (roleName) => {
    const translations = {
        can_create_partner: 'Partner létrehozása',
        can_create_role: 'Jogosultság létrehozása',
        can_create_user: 'Felhasználó létrehozása',
        can_delete_partner: 'Partner törlése',
        can_delete_role: 'Jogosultság törlése',
        can_delete_user: 'Felhasználó törlése',
        can_edit_partner: 'Partner szerkesztése',
        can_edit_role: 'Jogosultság szerkesztése',
        can_edit_user: 'Felhasználó szerkesztése',
        can_view_partners: 'Partnerek megtekintése',
        can_view_roles: 'Jogosultságok megtekintése',
        can_view_users: 'Felhasználók megtekintése'
    };

    return translations[roleName] || roleName;
}
