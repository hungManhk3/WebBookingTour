<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailBookingJob;
use App\Libraries\MomoPayment;
use App\Libraries\Notification;
use App\Libraries\Utilities;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Destination;
use App\Models\Review;
use App\Models\Tour;
use App\Models\Type;
use App\Services\ClientService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    protected $notification;
    protected $clientService;

    public function __construct(Notification $notification, ClientService $clientService)
    {
        $this->notification = $notification;
        $this->clientService = $clientService;
    }

    /**
     * Display a Homepage.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Destination $destination, Type $type, Tour $tour)
    {
        $destinations = $destination->getByStatus(1, 6);
        $types = $type->getByStatus(1, 3);
        $trendingTours = $tour->getByTrending(true, 3);
        $tours = $tour->getByStatus(1, 3);

        return view('index', compact(['destinations', 'trendingTours', 'types', 'tours']));
    }

    /**
     * Show list tour of destination.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function listTour(Request $request, $slug, Type $type)
    {
        $types = $type->getOrderByTitle();
        $tours = $this->clientService->getListTour($request, $slug);
        $filterDuration = $request->filter_duration ?? [];
        $filterType = $request->filter_type ?? [];
        $destination = Destination::where('slug', $slug)->first();

        return view('list_tour', compact(['tours', 'types', 'filterDuration', 'filterType', 'destination']));
    }

    /**
     * Show tour detail.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showTour(Request $request, $slug, Tour $tourModel)
    {
        $tour = $tourModel->getTourBySlug($slug);
        $tour->faqs = $tour->faqs(true)->get();
        $tour->reviews = $tour->reviews(true)->get();
        $relateTours = $tourModel->getRelated($tour);
        $reviews = $tour->reviews(true)->paginate(8);
        $rateReview = Utilities::calculatorRateReView($tour->reviews);

        return view('tour_detail', compact(['tour', 'relateTours', 'reviews', 'rateReview']));
    }

    /**
     * Show booking page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function booking(Request $request, $slug, Tour $tourModel)
    {
        $tour = $tourModel->getTourBySlug($slug);
        $people = $request->people;
        $departureTime = $request->departure_time;
        $listRooms = $request->room;
        $booking = null;

        return view('booking', compact(['tour', 'people', 'departureTime', 'listRooms', 'booking']));
    }

    /**
     * Display contact page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Store contact
     *
     * @param Request $request
     * @param Contact $contact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeContact(Request $request, Contact $contact)
    {
        $request->validate($contact->rules(), [], [
            'name' => 'tên',
            'email' => 'email',
            'phone' => 'số điện thoại',
            'message' => 'nội dung',
        ]);
        try {
            $contact->saveData($request);
            $this->notification->setMessage('Gửi phản hồi thành công', Notification::SUCCESS);

            return redirect()->route('index')->with($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Gửi phản hồi thất bại', Notification::ERROR);

            return back()
                ->with('exception', $e->getMessage())
                ->with($this->notification->getMessage())
                ->withInput();
        }
    }

    /**
     * Display search page.
     *
     * @param Request $request
     * @param Type $type
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function search(Request $request, Type $type)
    {
        $types = $type->getOrderByTitle();
        $tours = $this->clientService->searchTour($request);
        $filterDuration = $request->filter_duration ?? [];
        $filterType = $request->filter_type ?? [];

        return view('search', compact(['tours', 'types', 'filterDuration', 'filterType']));
    }

    /**
     * Display destination page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function destination()
    {
        $destinations = $this->clientService->listDestination();

        return view('destination', compact(['destinations']));
    }

    /**
     * Store review
     *
     * @param Request $request
     * @param $slug
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReview(Request $request, $slug, Review $review)
    {
        $request->validate($review->rules());
        try {
            $tour = Tour::where('slug', $slug)->firstOrFail();
            $review->saveData($request, $tour);
            $this->notification->setMessage('Đánh giá đã được gửi thành công', Notification::SUCCESS);

            return back()->with($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Đánh giá gửi không thành công', Notification::ERROR);

            return back()
                ->with('exception', $e->getMessage())
                ->with($this->notification->getMessage())
                ->withInput();
        }
    }

    public function thank()
    {
        return view('admin.bookings.thank');
    }

    /**
     * Store booking
     *
     * @param Request $request
     * @param $slug
     * @param Tour $tourModel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeBooking(Request $request, $slug, Tour $tourModel)
    {
        $tour = $tourModel->getTourBySlug($slug);
        $request->validate($this->clientService->ruleBooking(), [], [
            'first_name' => 'tên',
            'last_name' => 'họ',
            'phone' => 'điện thoại',
            'people' => 'sô người',
            'departure_time' => 'ngày',
            'payment_method' => 'loại thanh toán',
            'address' => 'địa chỉ',
            'city' => 'thành phố',
            'province' => 'huyện',
            'country' => 'quốc gia',
            'zipcode' => 'mã zipcode',
        ]);
        $this->notification->setMessage('Đặt tour thành công', Notification::SUCCESS);

        DB::beginTransaction();
        try {
            $booking = $this->clientService->storeBooking($request, $tour);
            if ($request->payment_method == PAYMENT_MOMO) {
                $orderIDMomo = 'MM' . time();
                $booking->invoice_no = $orderIDMomo;
                $booking->is_payment = PAYMENT_PAID;
                $booking->deposit = $booking->total;
                $booking->save();

                $response = MomoPayment::purchase([
                    'ipnUrl' => route('booking.momo.confirm'),
                    'redirectUrl' => route('booking.momo.redirect'),
                    'orderId' => $orderIDMomo,
                    'amount' => strval($booking->total),
                    'orderInfo' => 'Thanh toán hóa đơn đặt tour du lịch công ty VNViVu',
                    'requestId' => $orderIDMomo,
                    'extraData' => '',
                ]);

                if ($response->successful()) {
                    DB::commit();
                    return response()->json([
                        'url' => $response->json('payUrl'),
                        'response' => $response->json(),
                    ]);
                } else {
                    DB::rollBack();
                    $this->notification->setMessage('Serve Momo không phản hồi, vui lòng thử lại sau hoặc chọn phương thức thanh toán khác');
                }
            } else {
                DB::commit();
                dispatch(new SendMailBookingJob($booking));
            }
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            $this->notification->setMessage('Đặt tour không thành công', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
    }

    /* MOMO */
    public function redirectMomo(Request $request)
    {
        $data = $request->all();

        try {
            if (!MomoPayment::validateSignature($data)) {
                throw new Exception('Chữ ký không hợp lệ');
            }

            $orderId = $data['orderId'] ?? null;
            $booking = Booking::where('invoice_no', $orderId)->first();

            if (!$booking) {
                throw new Exception('Không tìm thấy hóa đơn');
            }

            if ($data['resultCode'] == 0) { 
                $booking->is_payment = PAYMENT_PAID;
                $booking->deposit = $booking->total;
                $booking->payment_method = PAYMENT_MOMO; 
                $booking->payment_info = json_encode($data); 
                $booking->save(); 
                return redirect()->route('booking.thank')->with('success', 'Thanh toán thành công!');
            } else {
                return redirect()->route('index')->with('error', 'Thanh toán thất bại: ' . $data['message']);
            }
        } catch (Exception $e) {
            return redirect()->route('index')->with('error', $e->getMessage());
        }
    }

    public function confirmMomo(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            if (!MomoPayment::validateSignature($data)) {
                throw new Exception('Chữ ký không hợp lệ');
            }

            $orderId = $data['orderId'] ?? null;
            $booking = Booking::where('invoice_no', $orderId)->first();

            if (!$booking) {
                throw new Exception('Không tìm thấy hóa đơn');
            }

            if ($data['resultCode'] == 0) {
                $booking->is_payment = PAYMENT_PAID;
                $booking->deposit = $booking->total;
                $booking->payment_method = PAYMENT_MOMO; 
                $booking->payment_info = json_encode($data); 
                $booking->save(); 
                DB::commit();
                return response()->json(['message' => 'Thanh toán thành công'], 200);
            } else {
                throw new Exception('Thanh toán thất bại: ' . $data['message']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function checkRoom(Request $request, $slug)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);
        $tourModel = new Tour();
        $tour = $tourModel->getTourBySlug($slug);
        $offsetDate = ($tour->duration - 1) * -1;
        $startDate = Carbon::parse($request->date)->addDays($offsetDate);
        $endDate = Carbon::parse($request->date);
        $bookings = Booking::with('booking_room')
            ->where('status', '!=', BOOKING_CANCEL)
            ->whereDate('departure_time', '>=', $startDate)
            ->whereDate('departure_time', '<=', $endDate)
            ->where('tour_id', $tour->id)
            ->get();

        $roomAvailable = [];
        foreach ($tour->rooms as $room) {
            $roomAvailable[$room->id] = $room->number;
        }

        foreach ($bookings as $booking) {
            foreach ($booking->booking_room as $bookingRoom) {
                $roomAvailable[$bookingRoom->room_id] -= $bookingRoom->number;
                if ($roomAvailable[$bookingRoom->room_id] < 0) {
                    $roomAvailable[$bookingRoom->room_id] = 0;
                }
            }
        }

        return response()->json([
            'date' => $request->date,
            'room_available' => $roomAvailable,
        ]);
    }
}
