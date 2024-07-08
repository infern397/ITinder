import { UserInterface } from "@/types/UserInterface";

export interface CardInterface {
    id: number;
    user: UserInterface;
    x: number;
    y: number;
    swipeDirection?: 'left' | 'right';
}
