// resources/js/app.jsx
import React, { useState,useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import axios from 'axios';
import { AppProvider, Page, Layout, Card, ResourceList, ResourceItem, Text, Box, LegacyCard, Button } from '@shopify/polaris'; // 更新导入内容
import '@shopify/polaris/build/esm/styles.css'; // 引入 Polaris 样式

// 配置项数据
// const initialItems = [
//   { id: 1, description: '功能1描述', enabled: false },
//   { id: 2, description: '功能2描述', enabled: true },
//   { id: 3, description: '功能3描述', enabled: false },
// ];

function App() {
  const [configItems, setConfigItems] = useState([]); // 初始为空数组
  const [loading, setLoading] = useState(true); // 用于控制加载状态

  // 模拟 API 请求的 URL，根据实际情况调整
  const apiUrl = '/api/saker-checkout-config';

  // 获取数据的函数
  const fetchConfigItems = async () => {
    try {
      setLoading(true); // 开始加载
      const response = await axios.get(apiUrl);
      setConfigItems(response.data); // 假设接口返回的数据格式是一个数组
    } catch (error) {
      console.error('获取配置项失败:', error);
    } finally {
      setLoading(false); // 加载完成
    }
  };

  // 使用 useEffect 在组件加载时获取数据
  useEffect(() => {
    fetchConfigItems();
  }, []);

  // 切换开关按钮
  const handleToggle = (id) => {
    setConfigItems((prevItems) =>
      prevItems.map((item) =>
        item.id === id ? { ...item, enabled: !item.enabled } : item
      )
    );
  };

  return (
    <AppProvider i18n={{}}>
      <Page title="配置页面">
        <Layout>
          <Layout.Section>
            <LegacyCard>
              <ResourceList
                resourceName={{ singular: 'item', plural: 'items' }}
                items={configItems}
                renderItem={(item) => {
                  const { id, description, enabled } = item;
                  return (
                    <ResourceItem id={id}>
                      <Box style={{
                            display: 'flex',
                            justifyContent: 'space-between',
                            alignItems: 'center',
                          }}>
                        <Text as="span" variant="bodyMd" color="subdued">
                          {description}
                        </Text>
                        <Button
                          pressed={enabled}
                          onClick={() => handleToggle(id)}
                          toggle
                          accessibilityLabel={enabled ? 'Disable' : 'Enable'}
                        >
                          {enabled ? '开启' : '关闭'}
                        </Button>
                      </Box>
                    </ResourceItem>
                  );
                }}
              />
            </LegacyCard>
          </Layout.Section>
        </Layout>
      </Page>
    </AppProvider>
  );
}

// 渲染 React 组件到页面
const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(<App />);