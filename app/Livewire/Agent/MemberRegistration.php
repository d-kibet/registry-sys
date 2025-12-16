<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Member;
use App\Models\Constituency;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class MemberRegistration extends Component
{
    use WithFileUploads;

    // Form fields
    public $first_name;
    public $second_name;
    public $third_name;
    public $phone_number;
    public $id_number;
    public $gender;
    public $polling_station;
    public $ward;
    public $constituency_id;
    public $verification_proof;
    public $latitude;
    public $longitude;
    public $wants_to_vie = false;
    public $vie_position = null;

    // UI state
    public $phoneExists = false;
    public $existingMemberMessage = '';
    public $showSuccess = false;
    public $registeredMemberId;
    public $availablePollingStations = [];

    protected function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'second_name' => ['nullable', 'string', 'max:255'],
            'third_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'regex:/^(0|\+254)[17]\d{8}$/', 'unique:members,phone_number'],
            'id_number' => ['required', 'numeric'],
            'gender' => ['required', 'in:Male,Female'],
            'polling_station' => ['required', 'string', 'max:255'],
            'ward' => ['required', 'in:Chepkunyuk,Kapchorua,Nandi Hills,Ollessos'],
            'constituency_id' => ['required', 'exists:constituencies,id'],
            'verification_proof' => ['required', 'image', 'max:2048'], // 2MB max
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'wants_to_vie' => ['boolean'],
            'vie_position' => ['nullable', 'string', 'in:Youth Representative,Women Representative,PWDs Representative,MSMEs Representative,Farmers Representative,Religious Groups Representative,Professionals Representative'],
        ];
    }

    protected $messages = [
        'phone_number.regex' => 'Phone number must be in Kenyan format (e.g., 0712345678 or +254712345678)',
        'phone_number.unique' => 'This phone number is already registered',
        'verification_proof.required' => 'Please upload a verification proof image',
        'verification_proof.image' => 'Verification proof must be an image file',
        'verification_proof.max' => 'Image size should not exceed 2MB',
    ];

    /**
     * Initialize component
     */
    public function mount()
    {
        // Auto-select constituency if only one is assigned to the company
        $user = Auth::user();
        $constituencies = $user->company->constituencies;

        if ($constituencies->count() === 1) {
            $this->constituency_id = $constituencies->first()->id;
        }
    }

    /**
     * Check if phone number already exists (real-time validation)
     */
    public function updatedPhoneNumber($value)
    {
        $this->phoneExists = false;
        $this->existingMemberMessage = '';

        if (!empty($value) && preg_match('/^(0|\+254)[17]\d{8}$/', $value)) {
            $member = Member::where('phone_number', $value)
                ->with(['registeredBy', 'company'])
                ->first();

            if ($member) {
                $this->phoneExists = true;
                $this->existingMemberMessage = sprintf(
                    'This phone number is already registered on %s by %s from %s',
                    $member->created_at->format('d/m/Y'),
                    $member->registeredBy?->name ?? 'Unknown Agent',
                    $member->company?->name ?? 'Unknown Company'
                );
            }
        }
    }

    /**
     * Update available polling stations when ward changes
     */
    public function updatedWard($value)
    {
        $this->polling_station = ''; // Reset polling station selection
        $this->availablePollingStations = $this->getPollingStationsByWard($value);
    }

    /**
     * Get polling stations by ward
     */
    protected function getPollingStationsByWard($ward)
    {
        $pollingStations = $this->getPollingStations();
        return $pollingStations[$ward] ?? [];
    }

    /**
     * Get all polling stations organized by ward
     */
    protected function getPollingStations()
    {
        return [
            'Nandi Hills' => [
                'Kipkimba Primary School',
                'Chemomi Primary School',
                'Mosine Primary School',
                'Kabote Secondary School',
                'Taito Primary School',
                'Kaplelmet Primary School',
                'Nandi-hills Primary School',
                'Kaptien Primary School',
                'Mokong Social Hall',
                'Nandi Tea Social Hall',
                'Our Lady Of Peace Secondary School',
                'Kabikwen Primary School',
                'Keteng Primary School',
                'Kimolonik Primary School',
                'Kipsamoo Primary School',
                'Kipsebwo Primary School',
                'Kipsitoi Primary School',
                'Kapsean Primary School',
                'Kaitet Nursery School',
                'Kapkechui Nursery School',
                'Kosoiywo Primary School',
                'Samoei Nursery School',
                'Sinendet Primary School',
                'Soiyet Primary School',
                'Tururo Nursery School',
            ],
            'Chepkunyuk' => [
                'Cheboin Social Hall',
                'Septon Primary School',
                'Chepkunyuk Primary School',
                'Chebinyin Primary School',
                'Chemartin Primary School',
                'Koisagat Primary School',
                'Choimim Primary School',
                'Kapchuriai Primary School',
                'Kogamei Primary School',
                'Kapkembur Primary School',
                'Chepkunyuk Secondary School',
                'Khartoum Primary School',
                'Kapsumbeiwo Factory Nursery School',
                'Lengubei Primary School',
                'St. Rebeca Catholic Church',
                'Kipchamo Primary School',
                'Kaputi Primary School',
                'Kapsumbeiwo Social Hall',
                'Kipkeigei Primary School',
                'Sokot Primary School',
                'Kipkoimet Primary School',
                'Ng\'ame Nursery School',
                'Kipkoror Primary School',
                'St. Teresa Primary School',
                'Lelwak Primary School',
                'Simbi Primary School',
                'Kibabet Primary School',
                'Sile Primary School',
                'Nduroto Primary School',
                'St. Ludovico Primary School',
                'Cheptabach Primary School',
                'Siret Social Hall',
                'Siwo Health Centre',
                'Siwo Primary School',
                'Taboiyat Primary School',
                'Kaboswa Primary School',
                'Tartar Nursery School',
                'Kipkeibon Primary School',
                'Tikityo Primary School',
            ],
            'Ollessos' => [
                'Chepng\'etuny Primary School',
                'Cheplelachbei Primary School',
                'Cheptuing\'eny Primary School',
                'Keben Primary School',
                'Lolkireny Primary School',
                'Kipkoech Tanui Primary School',
                'Koilot Primary School',
                'Ndururo Primary School',
                'Lolduga Primary School',
                'Mogoon Social Hall',
                'Ogirgir Primary School',
                'Chepting\'ting\' Primary School',
                'Ol\'lessos Ack Church',
                'Ol\'lessos Milk Plant',
                'Ol\'lessos Primary School',
                'Kamalel Primary School',
                'Kapnyemis Primary School',
                'Sochoi Primary School',
            ],
            'Kapchorua' => [
                'Ainapngetuny Primary School',
                'Kimwogi Primary School',
                'Kapchorua Primary School',
                'Timobo Primary School',
                'Kapkaititon Nursery School',
                'Kapkoros Primary School',
                'Kapsokio Primary School',
                'Mogobich Primary School',
                'Kipkorom Primary School',
                'Meteitei Youth Polytechnic',
                'Serengonik Primary School',
                'Simotwet Social Hall',
                'Sirwa Primary School',
                'Lengon Primary School',
                'Tereno Primary School',
                'Cherobon Primary School',
                'Great Highlands Primary School',
                'Kitechgaa Primary School',
            ],
        ];
    }

    /**
     * Submit registration
     */
    public function submit()
    {
        $this->validate();

        // Additional validation: Check if constituency is assigned to the company
        $user = Auth::user();
        $assignedConstituencyIds = $user->company->constituencies()->pluck('constituencies.id')->toArray();

        if (!in_array($this->constituency_id, $assignedConstituencyIds)) {
            $this->addError('constituency_id', 'This constituency is not assigned to your company. Please contact your administrator.');
            return;
        }

        try {
            // Optimize and store verification proof image
            $imagePath = $this->storeOptimizedImage($this->verification_proof);

            // Combine name fields for full_name
            $fullName = trim($this->first_name . ' ' . ($this->second_name ?? '') . ' ' . $this->third_name);

            // Create member record
            $member = Member::create([
                'company_id' => Auth::user()->company_id,
                'registered_by' => Auth::id(),
                'constituency_id' => $this->constituency_id,
                'first_name' => $this->first_name,
                'second_name' => $this->second_name,
                'third_name' => $this->third_name,
                'full_name' => $fullName,
                'phone_number' => $this->phone_number,
                'id_number' => $this->id_number,
                'gender' => $this->gender,
                'polling_station' => $this->polling_station,
                'ward' => $this->ward,
                'verification_proof_path' => $imagePath,
                'is_verified' => true,
                'verified_at' => now(),
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'wants_to_vie' => $this->wants_to_vie,
                'vie_position' => $this->wants_to_vie ? $this->vie_position : null,
                'registration_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Log the registration
            AuditLog::log('member_registered', $member, null, $member->toArray());

            // Flash success message to session
            session()->flash('success', 'Member registered successfully! Member ID: #' . $member->id);

            // Redirect to agent dashboard (home page)
            return redirect()->route('agent.dashboard');

        } catch (\Exception $e) {
            $this->addError('submit', 'Registration failed: ' . $e->getMessage());
        }
    }

    /**
     * Optimize and store image
     */
    protected function storeOptimizedImage($image)
    {
        $filename = uniqid() . '_' . time() . '.jpg';
        $path = storage_path('app/public/verification_proofs/' . $filename);

        // Create directory if it doesn't exist
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        // Optimize image: resize to max 1200px width and compress
        $img = Image::make($image->getRealPath());

        // Only resize if image is wider than 1200px
        if ($img->width() > 1200) {
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $img->encode('jpg', 80);

        $img->save($path);

        return 'verification_proofs/' . $filename;
    }

    /**
     * Reset form after successful submission
     */
    protected function resetForm()
    {
        $this->reset([
            'first_name',
            'second_name',
            'third_name',
            'phone_number',
            'id_number',
            'gender',
            'polling_station',
            'ward',
            'constituency_id',
            'verification_proof',
            'latitude',
            'longitude',
            'wants_to_vie',
            'vie_position',
            'phoneExists',
            'existingMemberMessage',
            'availablePollingStations',
        ]);
    }

    /**
     * Render the component
     */
    public function render()
    {
        // Get constituencies assigned to the agent's company (cached for 6 hours per company)
        $user = Auth::user();
        $companyId = $user->company_id;

        $constituencies = \Illuminate\Support\Facades\Cache::remember("company.{$companyId}.constituencies", now()->addHours(6), function () use ($user) {
            return $user->company->constituencies()->orderBy('county')->orderBy('name')->get();
        });

        return view('livewire.agent.member-registration', [
            'constituencies' => $constituencies,
        ]);
    }
}

