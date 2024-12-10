<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * 顯示會員資料頁面
     */
    public function index()
    {
        // 假設從數據庫獲取當前用戶信息
        $user = auth()->user();

        // 返回視圖，並傳遞用戶數據
        return view('profile.index', compact('user'));
    }

    /**
     * 處理更新會員資料的請求
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // 驗證請求
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        // 更新用戶資料
        $user->update($validatedData);

        // 返回成功提示
        return redirect()->route('profile.index')->with('success', '會員資料已更新！');
    }

    public function show()
    {
        $user = auth()->user();

        // MBTI 類型描述
        $mbtiDescriptions = [
            'ISTJ' => '安靜、嚴肅，通過全面性和可靠性獲得成功。重視傳統和忠誠。',
            'ISFJ' => '安靜、友好、有責任感和良知。善於體貼他人，重視小細節。',
            'INFJ' => '尋求思想、關係之間的意義和聯繫，富有遠見和責任心。',
            'INTJ' => '擁有非凡的動力和創新想法，能夠有效實現目標和規劃。',
            'ISTP' => '靈活、實際，喜歡分析事物運作原理並重視效率。',
            'ISFP' => '友好、敏感，忠於自己的價值觀，喜歡自由的空間。',
            'INFP' => '理想主義者，忠於內心價值觀，喜歡理解和幫助他人。',
            'INTP' => '喜歡理論性思考，安靜且具有解決問題的能力。',
            'ESTP' => '靈活、注重結果，喜歡行動解決問題，享受生活。',
            'ESFP' => '外向、友好，喜歡與他人合作完成任務並享受當下。',
            'ENFP' => '熱情、富有想象力，尋求可能性並樂於助人。',
            'ENTP' => '反應快、機智，善於解決挑戰性問題，喜歡探索新事物。',
            'ESTJ' => '實際、現實，善於組織和高效完成工作，重視邏輯標準。',
            'ESFJ' => '熱心、負責，善於協作和照顧他人的需求。',
            'ENFJ' => '熱情、善於激勵他人，注重他人的感受與成長。',
            'ENTJ' => '果斷、坦誠，具備天生的領導能力，喜歡制定計劃。',
        ];

        return view('profile.index', compact('user', 'mbtiDescriptions'));
    }
}
