export interface SkillInterface {
    id: number;
    name: string;
}

export interface UserInterface {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    profile_picture: string;
    bio: string;
    location: string;
    experience: string;
    github_link: string;
    linkedin_link: string;
    skills: SkillInterface[];
    seeking_skills: SkillInterface[];
}

export interface MatchInterface {
    id: number;
    user_id: number;
    matched_user_id: number;
    status: string;
    created_at: string | null;
    updated_at: string | null;
    user: UserInterface;
}
