<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        $categories = Category::withCount('products')->get();

        return view('settings.index', compact('users', 'categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('settings')->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();

        return redirect()->route('settings')->with('success', 'Catégorie supprimée avec succès.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('settings')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('settings')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
