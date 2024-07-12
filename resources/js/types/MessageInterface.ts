export interface MessageInterface {
    id: number;
    sender_id: number;
    receiver_id: number
    content: string
    read_at: string | null
    created_at: string
    updated_at: string
}
