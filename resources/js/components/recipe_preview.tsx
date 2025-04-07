"use client"

import { Clock, ChefHat } from "lucide-react"
import { Card, CardContent, CardFooter, CardHeader } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"

interface RecipePreviewProps {
    title: string
    description: string
    category: string
    duration: string
    is_breakfast: boolean
    image_url: string
}

export function RecipePreview({ title, description, category, duration, is_breakfast, image_url }: RecipePreviewProps) {

    return (
        <Card className="overflow-hidden h-fit">
            <div className="relative h-48 overflow-hidden">
                <img src={image_url || "https://i.pinimg.com/736x/72/d9/af/72d9af964d384fc2a16fd087c1062a7c.jpg"} alt={title} className="w-full h-full object-cover" />
                {is_breakfast && (
                    <div className="absolute top-2 right-2">
                        <Badge className="bg-amber-500 hover:bg-amber-600">{"Breakfast"}</Badge>
                    </div>
                )}
            </div>

            <CardHeader className="pb-2">
                <div className="flex justify-between items-start">
                    <h3 className="text-xl font-bold">{title || "Recipe Title"}</h3>
                    <Badge>{category}</Badge>
                </div>
            </CardHeader>
            <CardContent className="pb-2">
                <p className="text-muted-foreground line-clamp-3">
                    {description || "Recipe description will appear here..."}
                </p>
            </CardContent>
            <CardFooter className="flex justify-between pt-2 text-sm text-muted-foreground">
                <div className="flex items-center">
                    <Clock className="mr-1 h-4 w-4" />
                    <span>
            {duration || "30"} mins
          </span>
                </div>
                <div className="flex items-center">
                    <ChefHat className="mr-1 h-4 w-4" />
                    <span>{category}</span>
                </div>
            </CardFooter>
        </Card>
    )
}

