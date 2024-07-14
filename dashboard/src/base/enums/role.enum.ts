export class ERole {
    static readonly Public = "Public";

    static readonly ADMIN_VIEW = "ADMIN_VIEW";
    static readonly ADMIN_VIEW_ROLE = "ADMIN_VIEW_ROLE";
    static readonly ADMIN_CREATE = "ADMIN_CREATE";
    static readonly ADMIN_UPDATE = "ADMIN_UPDATE";
    static readonly ADMIN_UPDATE_ROLE = "ADMIN_UPDATE_ROLE";
    static readonly ADMIN_DELETE = "ADMIN_DELETE";

    static readonly USER_VIEW = "USER_VIEW";
    static readonly USER_CREATE = "USER_CREATE";
    static readonly USER_UPDATE = "USER_UPDATE";
    static readonly USER_DELETE = "USER_DELETE";
}

export class ERolePath {
    static readonly "/anasayfa" = ERole.Public;
    static readonly "/hesabim" = ERole.Public;

    static readonly "/yoneticiler" = ERole.ADMIN_VIEW;
    static readonly "/yoneticiler/ekle" = ERole.ADMIN_CREATE;
    static readonly "/yoneticiler/duzenle/:id" = ERole.ADMIN_UPDATE;
    static readonly "/yoneticiler/yetki/:id" = ERole.ADMIN_VIEW_ROLE;

    static readonly "/dosya-yoneticisi" = ERole.Public;
}
