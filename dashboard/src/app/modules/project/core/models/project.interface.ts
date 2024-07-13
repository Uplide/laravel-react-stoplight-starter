export interface IProjectResponseP {
  name: string;
  address: string;
  description: string;
  logo: string;
  email: string;
  phone?: string;
  phone_code?: string;
  id: number;
}

export interface IProjectCreateRequest {
  name: string;
  address: string;
  description: string;
  logo: string;
  email: string;
  phone?: string;
  phone_code?: string;
}

export interface IProjectUpdateRequest {
  name: string;
  address: string;
  description: string;
  logo: string;
  email: string;
  phone?: string;
  phone_code?: string;
}

//------

export enum EOptionType {
  text = "text",
  image = "image",
  text_video = "text_video",
  text_image = "text_image",
  video = "video",
  radio = "radio",
  checkbox = "checkbox",
}

export enum ESesType {
  HIGH = "HIGH",
  MIDDLE = "MIDDLE",
  IMMIGRANT_MINORITY = "IMMIGRANT_MINORITY",
  BELOW_POVERTY_LINE = "BELOW_POVERTY_LINE",
  LOW = "LOW",
}

export enum ESesTypeL {
  HIGH = "Zengin",
  MIDDLE = "Orta",
  LOW = "Düşük",
  IMMIGRANT_MINORITY = "Göçmen hazırlık",
  BELOW_POVERTY_LINE = "Yoksulluk sınırının altında",
}

export interface IProjectAddOption {
  option_value: string;
}

export interface IProjectQuestion {
  title: string;
  description: string;
  option_type: EOptionType;
  options: IProjectAddOption[];
  isCollapsed: boolean;
}

export interface IProjectAddModerator {
  name: string;
  surname: string;
  phone: string;
  phone_code: string;
  email: string;
  isCollapsed: boolean;
}

export interface IProjectAddObserver {
  name: string;
  surname: string;
  phone: string;
  phone_code: string;
  email: string;
  isCollapsed: boolean;
}

export interface IProjectAddAnnouncement {
  title: string;
  description: string;
  cover: string;
  isCollapsed: boolean;
  is_active: boolean;
}

export interface IProjectAddTargetGroup {
  title: string;
  description: string;
  ses: ESesType;
  isCollapsed: boolean;
  sort: number;
}

export interface IProjectAddTask {
  title: string;
  description: string; // Yeni alan
  cover: string; // Yeni alan
  start_date: string; // Yeni alan
  end_date: string;
  sort: number;
  questions: IProjectQuestion[];
  isCollapsed: boolean;
  is_active: boolean;
}

export interface IProjectAdd {
  title: string;
  description?: string; // Yeni alan
  cover: string; // Yeni alan
  company_id: number;
  start_date: string; // Yeni alan
  end_date: string; // Yeni alan
  moderators: IProjectAddModerator[];
  observers: IProjectAddObserver[];
  tasks: IProjectAddTask[];
  announcements: IProjectAddAnnouncement[];
  target_groups: IProjectAddTargetGroup[];
}
