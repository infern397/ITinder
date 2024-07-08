<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_picture' => $this->profile_picture,
            'bio' => $this->bio,
            'location' => $this->location,
            'experience' => $this->experience,
            'github_link' => $this->github_link,
            'linkedin_link' => $this->linkedin_link,
            'skills' => SkillResource::collection($this->skills)->resolve(),
            'seeking_skills' => SkillResource::collection($this->seekingSkills)->resolve(),
        ];
    }
}
