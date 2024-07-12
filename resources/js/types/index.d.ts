import { Config } from 'ziggy-js';
import {SkillInterface} from "@/types/UserInterface";

export interface User {
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

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
};
