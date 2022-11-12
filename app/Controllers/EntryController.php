<?php

namespace App\Controllers;


use App\Entities\Entry;
use App\Models\AuthException;
use App\Models\CategoryModel;
use App\Models\EntryModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Files\Exceptions\FileException;
use CodeIgniter\HTTP\Exceptions\HTTPException;
use CodeIgniter\HTTP\IncomingRequest;
use Ramsey\Uuid\Uuid;
use function App\Helpers\createEntryFromForm;
use function App\Helpers\createEntryImage;
use function App\Helpers\deleteEntry;
use function App\Helpers\getAllRoles;
use function App\Helpers\getEntry;
use function App\Helpers\getEntryWithRoleAndCategory;
use function App\Helpers\insertEntry;
use function App\Helpers\protectRoute;
use function App\Helpers\saveEntry;

class EntryController extends BaseController
{
    /**
     * @throws AuthException
     */
    public function index()
    {
        helper('auth');
        $db = db_connect();

        $entries = $db->table(getenv('database.views.entriesWithCategoryAndRole'))->get()->getResult();
        return $this->render('entries/EntryView', ['entries' => $entries]);
    }


    public function create()
    {
        return $this->render('entries/CreateEntryView', [
            'categories' => getCategories(),
            'roles' => getAllRoles()]);
    }


    /**
     * @throws \ReflectionException
     */
    public function store()
    {
        $request = $this->request;
        $entry = createEntryFromForm($request, Uuid::uuid4()->toString());
        try {
            $img = $request->getFile('image');
            if (!$img->hasMoved()) {
                $extension = $img->guessExtension();
                $img->move('uploads/', $entry->entry_id . "." . $img->guessExtension(), true);
                $filePath = "uploads/$entry->entry_id.$extension";
                createEntryImage($filePath);
            }

        } catch (HTTPException $exception){
        }
        insertEntry($entry);
        return redirect('entries');

    }

    /**
     * @throws \ReflectionException
     * @throws AuthException
     */
    public function edit($entryId)
    {
        $request = $this->request;
        $entry = getEntryWithRoleAndCategory($entryId);
        return $this->render('entries/EditEntryView', [
            'entry' => $entry,
            'categories' => getCategories(),
            'roles' => getAllRoles()
        ]);
    }

    /**
     * @throws \ReflectionException
     */
    public function update($entryId)
    {
        $request = $this->request;
        $entry = createEntryFromForm($request, $entryId);
        try {
            $img = $request->getFile('image');
            if (!$img->hasMoved()) {
                $extension = $img->guessExtension();
                $img->move('uploads/', $entry->entry_id . "." . $img->guessExtension(), true);
                $filePath = "uploads/$entry->entry_id.$extension";
                createEntryImage($filePath);
        }

        } catch (HTTPException $exception){
        }
        saveEntry($entry);
        return redirect('entries');
    }

    public function delete($entryId)
    {
       deleteEntry($entryId);
        return redirect('entries');
    }


}
