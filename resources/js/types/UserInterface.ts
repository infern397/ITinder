export interface SkillInterface {
    id: number;
    name: string;
}

export interface UserInterface {
    id: number;
    name: string;
    email: string;
    profile_picture: string;
    bio: string;
    location: string;
    experience: string;
    github_link: string;
    linkedin_link: string;
    skills: SkillInterface[];
    seekingSkills: SkillInterface[];
}
