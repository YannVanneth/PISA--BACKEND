import { Card } from '@/components/ui/card';
import { recipe } from '@/pages/recipes/recipe';

export default function RecipeGridView({ recipe }: { recipe: recipe[] }) {
    return (
        <div className="grid grid-cols-2 gap-x-4 gap-y-8 md:grid-cols-4 lg:grid-cols-6 p-0">
            {recipe.map((recipe) => (
                <Card key={recipe.id} className="shadow-card p-0 pb-4">
                    <img src={recipe.image_url} alt={recipe.title_en} className="rounded-t-sm h-[20em] object-cover" />
                    <div className="grid gap-2 px-2">
                        <span className="font-bold">{recipe.title_en}</span>
                        <p>{recipe.description_en}</p>
                    </div>
                </Card>
            ))}
        </div>
    );
}
