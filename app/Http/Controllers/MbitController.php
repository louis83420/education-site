<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MbitController extends Controller
{
    /**
     * 顯示 MBTI 測驗表單
     */
    public function index()
    {
        // 從資料庫獲取問題，按部分分類
        $part1 = DB::table('questions')->where('part', 'part1')->get();
        $part2 = DB::table('questions')->where('part', 'part2')->get();
        $part3 = DB::table('questions')->where('part', 'part3')->get();

        // 返回表單頁面，傳遞問題
        return view('mbti.trymbti', compact('part1', 'part2', 'part3'));
    }

    /**
     * 處理 MBTI 表單提交
     */
    public function submit(Request $request)
    {
        // 驗證表單輸入
        $validated = $request->validate([
            'answers' => 'required|array', // 確保 answers 存在且為陣列
        ]);

        // 收集答案
        $answers = $validated['answers'];

        // 計算分數邏輯
        $result = $this->calculateMBTI($answers);

        $type = ''; // 根據分數計算的 MBTI 類型
        $type .= $result['E'] >= $result['I'] ? 'E' : 'I';
        $type .= $result['S'] >= $result['N'] ? 'S' : 'N';
        $type .= $result['T'] >= $result['F'] ? 'T' : 'F';
        $type .= $result['J'] >= $result['P'] ? 'J' : 'P';

        // 類型描述
        $mbtiDescriptions = [
            'ISTJ' => '檢查員型：安靜、嚴肅，通過全面性和可靠性獲得成功。實際，有責任感。決定有邏輯性，並一步步地朝著目標前進，不易分心。重視傳統和忠誠。',
            'ISFJ' => '照顧者型：安靜、友好、有責任感和良知。堅定地致力於完成義務。全面、勤勉、精確，忠誠、體貼，留心和記得他們重視的人的小細節。',
            'INFJ' => '博愛型：尋求思想、關係、物質等之間的意義和聯繫。希望了解什麼能夠激勵人，有很強的洞察力。有責任心，堅持自己的價值觀。',
            'INTJ' => '專家型：在實現自己的想法和達成目標時有創新想法和非凡的動力。能很快洞察事物間的規律並形成長期計畫。',
            'ISTP' => '冒險家型：靈活、忍耐力強，是個安靜的觀察者直到有問題發生。分析事物原理，用邏輯的方式處理問題，重視效率。',
            'ISFP' => '藝術家型：安靜、友好、敏感、和善。喜歡自己的空間，忠於自己的價值觀。不喜歡爭論和衝突。',
            'INFP' => '哲學家型：理想主義，忠於自己的價值觀。希望外部生活與內心價值觀統一，尋求理解並幫助他人實現潛能。',
            'INTP' => '學者型：對感興趣的事物尋求合理解釋。喜歡理論性和抽象事物，專注於感興趣的領域並深度解決問題。',
            'ESTP' => '挑戰者型：靈活、忍耐力強，注重結果。喜歡積極地採取行動解決問題，享受與他人相處的時刻。',
            'ESFP' => '表演者型：外向、友好、接受力強。熱愛生活、人類和物質上的享受，靈活自然不做作，快速適應新事物。',
            'ENFP' => '公關型：熱情洋溢、富有想像力。相信人生充滿可能性，靈活自然不做作，善於即興發揮和言語流暢。',
            'ENTP' => '智多星型：反應快、睿智，有激勵他人的能力。善於解決新問題，具有戰略眼光和分析能力，不喜歡例行公事。',
            'ESTJ' => '管家型：實際、現實主義。善於組織人和項目並高效完成，注重日常細節，有清晰的邏輯標準。',
            'ESFJ' => '主人型：熱心腸、有責任心、合作。善於體察他人的需求，為團體創造和諧氛圍，忠誠並注重他人認可。',
            'ENFJ' => '教導型：熱情、為他人著想、有責任心。善於激發他人潛能，幫助個人成長，有良好的社交和領導能力。',
            'ENTJ' => '統帥型：坦誠、果斷，有天生的領導能力。善於計劃並實施長期目標，見多識廣，陳述自己的想法時強而有力。',
        ];


        // 將結果保存到當前用戶的資料
        $user = auth()->user();
        $user->mbti = $type;
        $user->save();
        // 將結果返回到結果頁面
        return view('mbti.result', ['result' => $result]);
    }



    /**
     * 計算 MBTI 測驗結果
     */
    private function calculateMBTI($answers)
    {
        // 初始化各類型分數
        $score = [
            'E' => 0,
            'I' => 0,
            'S' => 0,
            'N' => 0,
            'T' => 0,
            'F' => 0,
            'J' => 0,
            'P' => 0,
        ];

        // MBTI 計分邏輯
        foreach ($answers as $questionId => $answerValue) {
            // 根據答案值（E/I, S/N, T/F, J/P）更新對應分數
            if (array_key_exists($answerValue, $score)) {
                $score[$answerValue]++;
            }
        }

        // 返回計算結果
        return $score;
    }
}
